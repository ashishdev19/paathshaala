<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\OnlineClass;
use App\Models\Certificate;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        // Middleware is handled at route level
    }

    public function dashboard()
    {
        $student = Auth::user();
        
        // Get student's enrollments with courses
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course.teacher', 'course.onlineClasses'])
            ->latest()
            ->get();

        $enrolledCourseIds = $enrollments->pluck('course_id');

        // Calculate statistics
        $stats = [
            'total_enrollments' => $enrollments->count(),
            'active_courses' => $enrollments->where('status', 'active')->count(),
            'completed_courses' => $enrollments->where('status', 'completed')->count(),
            'certificates_earned' => Certificate::where('student_id', $student->id)->count(),
            'total_payments' => Payment::where('student_id', $student->id)->sum('final_amount'),
            'average_progress' => $enrollments->avg('progress_percentage') ?? 0,
        ];

        // Upcoming classes
        $upcomingClasses = OnlineClass::whereIn('course_id', $enrolledCourseIds)
            ->where('scheduled_at', '>', now())
            ->with('course')
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        // Recent certificates
        $certificates = Certificate::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->take(3)
            ->get();

        // Recent payments
        $recentPayments = Payment::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'stats',
            'enrollments', 
            'upcomingClasses',
            'certificates',
            'recentPayments'
        ));
    }

    public function courses()
    {
        $student = Auth::user();
        
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course.teacher', 'course.onlineClasses'])
            ->paginate(9);

        return view('student.courses.index', compact('enrollments'));
    }

    public function courseDetail($id)
    {
        $student = Auth::user();
        
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $id)
            ->with(['course.teacher', 'course.onlineClasses', 'course.reviews'])
            ->firstOrFail();

        $classes = OnlineClass::where('course_id', $id)
            ->orderBy('order')
            ->get();

        return view('student.courses.show', compact('enrollment', 'classes'));
    }

    public function certificates()
    {
        $student = Auth::user();
        
        $certificates = Certificate::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->paginate(10);

        return view('student.certificates.index', compact('certificates'));
    }

    public function payments()
    {
        $student = Auth::user();
        
        $payments = Payment::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->paginate(10);

        return view('student.payments.index', compact('payments'));
    }

    public function classes()
    {
        $student = Auth::user();
        
        $enrolledCourseIds = Enrollment::where('student_id', $student->id)
            ->pluck('course_id');

        $classes = OnlineClass::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->latest('scheduled_at')
            ->paginate(10);

        return view('student.classes.index', compact('classes'));
    }
}