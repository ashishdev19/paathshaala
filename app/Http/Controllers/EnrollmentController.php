<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Services\NotificationService;
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
            return redirect()->back()->with('error', 'You are already enrolled in this course.');
        }

        // Validate payment method
        $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,upi,net_banking',
            'card_number' => 'required_if:payment_method,credit_card,debit_card|nullable|string|size:16',
            'card_expiry' => 'required_if:payment_method,credit_card,debit_card|nullable|string',
            'card_cvv' => 'required_if:payment_method,credit_card,debit_card|nullable|string|size:3',
            'card_holder_name' => 'required_if:payment_method,credit_card,debit_card|nullable|string',
            'upi_id' => 'required_if:payment_method,upi|nullable|email',
            'bank_name' => 'required_if:payment_method,net_banking|nullable|string',
        ]);

        try {
            $enrollment = null;
            $payment = null;
            
            DB::transaction(function () use ($request, $course, $user, &$enrollment, &$payment) {
                // Create enrollment
                $enrollment = Enrollment::create([
                    'student_id' => $user->id,
                    'course_id' => $course->id,
                    'enrolled_at' => now(),
                    'progress_percentage' => 0,
                    'status' => 'active',
                ]);

                // Process payment
                $payment = $this->processPayment($request, $course, $user, $enrollment);

                // If payment successful, confirm enrollment
                if ($payment->status === 'completed') {
                    $enrollment->update(['payment_status' => 'paid']);
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

            return redirect()->route('enrollment.success')
                ->with('success', 'Successfully enrolled in ' . $course->title . '! Welcome to the course.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Payment processing failed. Please try again.')
                ->withInput();
        }
    }

    private function processPayment(Request $request, Course $course, $user, Enrollment $enrollment)
    {
        // Simulate payment processing (in real implementation, integrate with payment gateway)
        $paymentData = [
            'student_id' => $user->id,
            'course_id' => $course->id,
            'enrollment_id' => $enrollment->id,
            'amount' => $course->price,
            'payment_method' => $request->payment_method,
            'transaction_id' => 'TXN_' . strtoupper(Str::random(10)),
            'payment_date' => now(),
            'status' => 'completed', // In real implementation, this would depend on gateway response
        ];

        // Store payment details based on method
        switch ($request->payment_method) {
            case 'credit_card':
            case 'debit_card':
                $paymentData['payment_details'] = json_encode([
                    'card_last_four' => substr($request->card_number, -4),
                    'card_holder_name' => $request->card_holder_name,
                    'card_type' => $this->detectCardType($request->card_number),
                ]);
                break;
            case 'upi':
                $paymentData['payment_details'] = json_encode([
                    'upi_id' => $request->upi_id,
                ]);
                break;
            case 'net_banking':
                $paymentData['payment_details'] = json_encode([
                    'bank_name' => $request->bank_name,
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
        $user = Auth::user();

        // Check if user is already enrolled
        $existingEnrollment = Enrollment::where('student_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.show', $course->id)
                ->with('info', 'You are already enrolled in this course.');
        }

        return view('enrollment.checkout', compact('course'));
    }

    public function success()
    {
        return view('enrollment.success');
    }
}