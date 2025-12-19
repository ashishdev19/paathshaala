<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\TeacherEnquiry;
use Illuminate\Http\Request;

class InstructorEnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'myEnquiry']);
        $this->middleware('role:admin')->only(['index', 'show', 'approve', 'reject']);
    }

    // Public registration form
    public function create()
    {
        // Check if user already has pending/approved enquiry
        $existingEnquiry = TeacherEnquiry::where('email', auth()->user()->email)
                                        ->whereIn('status', ['pending', 'approved'])
                                        ->first();

        if ($existingEnquiry) {
            if ($existingEnquiry->status === 'approved') {
                return redirect()->route('instructor.subscription.show')
                               ->with('info', 'You are already registered as a teacher!');
            }
            return redirect()->route('teacher.enquiry.status')
                           ->with('info', 'Your application is under review.');
        }

        $plans = SubscriptionPlan::active()->orderBy('priority')->get();
        return view('teacher.enquiry.create', compact('plans'));
    }

    // Submit enquiry
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teacher_enquiries|unique:users,email',
            'phone_number' => 'required|string|max:20',
            'qualification' => 'required|string|max:255',
            'experience' => 'required|integer|min:0|max:70',
            'bio' => 'required|string|max:1000',
            'subject_expertise' => 'required|string|max:500',
            'plan_id' => 'required|exists:subscription_plans,id',
            'agree_terms' => 'required|accepted',
        ]);

        // Create enquiry
        $enquiry = TeacherEnquiry::create($validated);

        return redirect()->route('teacher.enquiry.status')
                       ->with('success', 'Application submitted successfully! We will review it soon.');
    }

    // Check enquiry status
    public function status()
    {
        $user = auth()->user();
        $enquiry = TeacherEnquiry::where('email', $user->email)->first();

        if (!$enquiry) {
            return view('teacher.enquiry.no-enquiry');
        }

        return view('teacher.enquiry.status', compact('enquiry'));
    }

    // Admin endpoints
    public function index()
    {
        $enquiries = TeacherEnquiry::latest()->paginate(20);
        $stats = [
            'pending' => TeacherEnquiry::pending()->count(),
            'approved' => TeacherEnquiry::approved()->count(),
            'rejected' => TeacherEnquiry::rejected()->count(),
        ];

        return view('admin.subscriptions.enquiries.index', compact('enquiries', 'stats'));
    }

    public function show(TeacherEnquiry $enquiry)
    {
        return view('admin.subscriptions.enquiries.show', compact('enquiry'));
    }

    public function approve(Request $request, TeacherEnquiry $enquiry)
    {
        if ($enquiry->status !== 'pending') {
            return back()->with('error', 'Only pending enquiries can be approved.');
        }

        $enquiry->approve(auth()->id());

        return back()->with('success', 'Enquiry approved!');
    }

    public function reject(Request $request, TeacherEnquiry $enquiry)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        if ($enquiry->status !== 'pending') {
            return back()->with('error', 'Only pending enquiries can be rejected.');
        }

        $enquiry->reject($validated['rejection_reason'], auth()->id());

        return back()->with('success', 'Enquiry rejected!');
    }
}
