<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Offer;
use App\Services\NotificationService;
use App\Services\ReferralService;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EnrollmentController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if user is already enrolled
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            // Check if request is AJAX
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'already_enrolled' => true,
                    'message' => 'You are already enrolled in this course.',
                    'course_id' => $course->id
                ], 422);
            }
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        // Validate payment method (relaxed for development)
        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,upi,net_banking',
            'card_number' => 'nullable|string|max:16',
            'card_expiry' => 'nullable|string|max:5',
            'card_cvv' => 'nullable|string|max:3',
            'card_holder_name' => 'nullable|string|max:255',
            'upi_id' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
        ]);
        
        \Log::info('Enrollment attempt', [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'payment_method' => $request->payment_method
        ]);

        try {
            $enrollment = null;
            $payment = null;
            
            DB::transaction(function () use ($request, $course, $user, &$enrollment, &$payment) {
                // Check if user is new student and apply discount
                $finalPrice = $course->price;
                $appliedOffer = null;
                $referralDiscount = 0;
                $appliedReferral = null;
                
                // Check for referral discount first
                $referralService = app(ReferralService::class);
                $pendingReferral = $referralService->getAvailableDiscount($user);
                
                if ($pendingReferral) {
                    $referralDiscount = $pendingReferral->referred_discount;
                    $finalPrice -= $referralDiscount;
                    $appliedReferral = $pendingReferral;
                }
                
                $isNewStudent = !Enrollment::where('student_id', $user->id)->exists();
                if ($isNewStudent) {
                    $newStudentOffer = Offer::active()
                        ->valid()
                        ->available()
                        ->where('code', 'NEWSTUDENT30')
                        ->first();
                        
                    if ($newStudentOffer && $newStudentOffer->canBeUsed($finalPrice)) {
                        $discount = $newStudentOffer->calculateDiscount($finalPrice);
                        $finalPrice = $finalPrice - $discount;
                        $appliedOffer = $newStudentOffer;
                        
                        // Increment usage count
                        $newStudentOffer->increment('used_count');
                    }
                }

                // Create enrollment with expiry date
                $enrollmentData = [
                    'student_id' => $user->id,
                    'course_id' => $course->id,
                    'enrolled_at' => now(),
                    'progress_percentage' => 0,
                    'status' => 'active',
                ];

                // Set expiry date based on course validity
                if (!$course->is_lifetime) {
                    $enrollmentData['expires_at'] = $course->calculateExpiryDate(now());
                    $enrollmentData['is_expired'] = false;
                }

                $enrollment = Enrollment::create($enrollmentData);

                // Process payment with discounted price
                $payment = $this->processPayment($request, $course, $user, $enrollment, $finalPrice, $appliedOffer, $referralDiscount);

                // If payment successful, confirm enrollment
                if ($payment->status === 'completed') {
                    $enrollment->update(['payment_status' => 'paid']);
                    
                    // Apply referral discount and credit referrer
                    if ($appliedReferral) {
                        $referralService->applyReferralDiscount($user, $enrollment->id);
                    }
                } else {
                    throw new \Exception('Payment processing failed');
                }
            });

            // Send notifications and emails after successful transaction
            if ($payment && $payment->status === 'completed') {
                // Create enrollment confirmation notification
                NotificationService::enrollmentConfirmation($user, $course);
                
                // Create payment confirmation notification
                NotificationService::paymentConfirmation($user, $payment, $course);
                
                // Notify teacher about new student
                NotificationService::newStudentEnrolled($course->teacher, $user, $course);
                
                // Send enrollment confirmation email
                try {
                    Mail::to($user->email)->send(new EnrollmentConfirmation($user, $course, $enrollment));
                } catch (\Exception $e) {
                    // Log email error but don't fail the enrollment
                    \Log::warning('Failed to send enrollment confirmation email: ' . $e->getMessage());
                }
            }

            // Check if request is AJAX
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully enrolled in ' . $course->title . '! Welcome to the course.',
                    'course_title' => $course->title,
                    'course_id' => $course->id
                ]);
            }

            // Fallback: Redirect to the course content page for non-AJAX requests
            // Don't redirect - this is now handled by AJAX with modal
            // Keeping this as fallback only
            return redirect()->back()
                ->with('success', 'Successfully enrolled in ' . $course->title . '! Welcome to the course.');

        } catch (\Exception $e) {
            \Log::error('Enrollment failed', [
                'user_id' => $user->id,
                'course_id' => $course->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Check if request is AJAX
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Enrollment failed: ' . $e->getMessage()
                ], 422);
            }
            
            return redirect()->back()
                ->with('error', 'Enrollment failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function processPayment(Request $request, Course $course, $user, Enrollment $enrollment, $finalPrice = null, $appliedOffer = null, $referralDiscount = 0)
    {
        $amount = $finalPrice ?? $course->price;
        $totalDiscount = ($course->price - $amount) + $referralDiscount;
        
        // Development mode: Set default values if not provided
        $cardNumber = $request->card_number ?? '4111111111111111';
        $cardHolderName = $request->card_holder_name ?? 'Test User';
        $upiId = $request->upi_id ?? 'test@upi';
        $bankName = $request->bank_name ?? 'Test Bank';
        
        // Simulate payment processing (in real implementation, integrate with payment gateway)
        $paymentData = [
            'student_id' => $user->id,
            'course_id' => $course->id,
            'enrollment_id' => $enrollment->id,
            'amount' => $amount,
            'original_amount' => $course->price,
            'discount_amount' => $totalDiscount,
            'final_amount' => $amount,
            'offer_id' => $appliedOffer ? $appliedOffer->id : null,
            'platform_commission' => 0.00,
            'teacher_earnings' => $amount,
            'payment_method' => $request->payment_method,
            'paid_via_wallet' => false,
            'transaction_id' => 'TXN_' . strtoupper(Str::random(10)),
            'status' => 'completed', // In real implementation, this would depend on gateway response
        ];

        // Store payment details based on method
        switch ($request->payment_method) {
            case 'credit_card':
            case 'debit_card':
                $paymentData['payment_details'] = json_encode([
                    'card_last_four' => substr($cardNumber, -4),
                    'card_holder_name' => $cardHolderName,
                    'card_type' => $this->detectCardType($cardNumber),
                    'referral_discount' => $referralDiscount,
                    'dev_mode' => true,
                ]);
                break;
            case 'upi':
                $paymentData['payment_details'] = json_encode([
                    'upi_id' => $upiId,
                    'referral_discount' => $referralDiscount,
                    'dev_mode' => true,
                ]);
                break;
            case 'net_banking':
                $paymentData['payment_details'] = json_encode([
                    'bank_name' => $bankName,
                    'referral_discount' => $referralDiscount,
                    'dev_mode' => true,
                ]);
                break;
        }

        return Payment::create($paymentData);
    }

    private function detectCardType($cardNumber)
    {
        $firstDigit = substr($cardNumber, 0, 1);
        $firstTwoDigits = substr($cardNumber, 0, 2);

        if ($firstDigit == '4') {
            return 'Visa';
        } elseif (in_array($firstTwoDigits, ['51', '52', '53', '54', '55'])) {
            return 'MasterCard';
        } elseif (in_array($firstTwoDigits, ['34', '37'])) {
            return 'American Express';
        } else {
            return 'Unknown';
        }
    }

    public function checkout(Course $course)
    {
        // Load category relationship
        $course->load('category', 'teacher');
        
        $user = Auth::user();

        // Check if user is already enrolled
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('student.dashboard')
                ->with('info', 'You are already enrolled in this course.');
        }

        // Check for referral discount
        $referralService = app(ReferralService::class);
        $pendingReferral = $referralService->getAvailableDiscount($user);
        $referralDiscount = $pendingReferral ? $pendingReferral->referred_discount : 0;

        // Check if user is a new student (no previous enrollments)
        $isNewStudent = !Enrollment::where('student_id', $user->id)->exists();
        
        // Get available offers for new students
        $availableOffers = collect();
        $autoAppliedOffer = null;
        $discountedPrice = $course->price - $referralDiscount;
        
        if ($isNewStudent) {
            // Find the best new student offer
            $newStudentOffer = Offer::active()
                ->valid()
                ->available()
                ->where('code', 'NEWSTUDENT30')
                ->first();
                
            if ($newStudentOffer && $newStudentOffer->canBeUsed($discountedPrice)) {
                $autoAppliedOffer = $newStudentOffer;
                $discount = $newStudentOffer->calculateDiscount($discountedPrice);
                $discountedPrice = $discountedPrice - $discount;
            }
        }
        
        // Get all available offers for display
        $allOffers = Offer::active()
            ->valid()
            ->available()
            ->get()
            ->filter(function($offer) use ($course) {
                return $offer->canBeUsed($course->price) && $offer->isValidForCourse($course->id);
            });

        return view('enrollment.checkout', compact(
            'course', 
            'isNewStudent', 
            'autoAppliedOffer', 
            'discountedPrice', 
            'allOffers',
            'pendingReferral',
            'referralDiscount'
        ));
    }

    public function success()
    {
        return view('enrollment.success');
    }
}