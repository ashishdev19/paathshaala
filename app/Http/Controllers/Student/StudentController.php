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
use Illuminate\Support\Facades\Hash;

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
        
        // Get only courses where student is enrolled
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course.teacher'])
            ->latest()
            ->paginate(9);

        return view('student.courses.index', compact('enrollments'));
    }

    public function browseCourses(Request $request)
    {
        $student = Auth::user();
        
        // Get courses student is already enrolled in
        $enrolledCourseIds = Enrollment::where('student_id', $student->id)
            ->pluck('course_id')
            ->toArray();

        // Get all active courses with search and filter options
        $query = Course::where('is_active', true)
            ->with(['teacher', 'enrollments', 'reviews', 'category']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('category', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Filter by level
        if ($request->has('level') && $request->level) {
            $query->where('level', $request->level);
        }

        // Sort options
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->withCount('enrollments')->orderBy('enrollments_count', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $courses = $query->paginate(12);

        // Get unique categories and levels for filters
        $categories = \App\Models\CourseCategory::where('status', 'active')
            ->orderBy('name')
            ->pluck('name', 'id');

        $levels = ['beginner', 'intermediate', 'advanced'];

        return view('student.courses.browse', compact('courses', 'enrolledCourseIds', 'categories', 'levels'));
    }

    public function coursePreview($id)
    {
        $student = Auth::user();
        
        // Get course details for preview before enrollment
        $course = Course::where('id', $id)
            ->where('is_active', true)
            ->with(['teacher', 'enrollments', 'reviews.user'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->firstOrFail();

        // Check if student is already enrolled
        $isEnrolled = Enrollment::where('student_id', $student->id)
            ->where('course_id', $id)
            ->exists();

        // Get similar courses
        $similarCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('is_active', true)
            ->with('teacher')
            ->limit(3)
            ->get();

        return view('student.courses.show', compact('course', 'isEnrolled', 'similarCourses'));
    }

    public function courseDetail($id)
    {
        $student = Auth::user();
        
        // Get course details
        $course = Course::with(['teacher', 'onlineClasses', 'reviews.user', 'category'])
            ->withCount(['enrollments', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);
        
        // Check if student is already enrolled
        $isEnrolled = Enrollment::where('student_id', $student->id)
            ->where('course_id', $id)
            ->exists();
        
        // Get enrollment if exists
        $enrollment = null;
        if ($isEnrolled) {
            $enrollment = Enrollment::where('student_id', $student->id)
                ->where('course_id', $id)
                ->with(['course.teacher', 'course.onlineClasses'])
                ->first();
        }

        // Get related courses
        $relatedCourses = Course::where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->where('status', 'published')
            ->with('teacher')
            ->limit(3)
            ->get();

        return view('courses.show', compact('course', 'isEnrolled', 'enrollment', 'relatedCourses'));
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

    public function enrollments()
    {
        $student = Auth::user();
        
        $enrollments = Enrollment::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->paginate(10);

        return view('student.enrollments.index', compact('enrollments'));
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

        return view('student.courses.index', compact('classes'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'qualification' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update basic information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->dob = $validated['dob'] ?? $user->dob;
        $user->address = $validated['address'] ?? $user->address;
        $user->qualification = $validated['qualification'] ?? $user->qualification;
        $user->institution = $validated['institution'] ?? $user->institution;

        // Handle password change if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            
            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->route('student.dashboard')
            ->with('success', 'Profile updated successfully');
    }
}