<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\OnlineClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function __construct()
    {
        // Middleware is handled at route level
    }

    public function dashboard()
    {
        $teacher = Auth::user();
        
        // Get teacher's courses
        $teacherCourses = Course::where('teacher_id', $teacher->id)->get();
        $courseIds = $teacherCourses->pluck('id');
        
        // Calculate statistics
        $stats = [
            'total_courses' => $teacherCourses->count(),
            'total_students' => Enrollment::whereIn('course_id', $courseIds)->distinct('student_id')->count(),
            'total_enrollments' => Enrollment::whereIn('course_id', $courseIds)->count(),
            'active_courses' => $teacherCourses->where('is_active', true)->count(),
            'pending_courses' => $teacherCourses->where('is_active', false)->count(),
            'completed_courses' => 0, // We'll implement this logic later
        ];

        // Recent enrollments in teacher's courses
        $recentEnrollments = Enrollment::with(['student', 'course'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->take(5)
            ->get();

        // Upcoming classes
        $upcomingClasses = OnlineClass::whereIn('course_id', $courseIds)
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at')
            ->take(5)
            ->get();

        // Students per course
        $studentsPerCourse = [];
        foreach ($teacherCourses as $course) {
            $studentsPerCourse[] = [
                'course' => $course,
                'student_count' => Enrollment::where('course_id', $course->id)->count()
            ];
        }

        return view('instructor.dashboard.index', compact(
            'stats', 
            'recentEnrollments', 
            'upcomingClasses', 
            'studentsPerCourse',
            'teacherCourses'
        ));
    }

    public function courses()
    {
        $teacher = Auth::user();
        $courses = Course::where('teacher_id', $teacher->id)
            ->withCount('enrollments')
            ->latest()
            ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    public function students()
    {
        $teacher = Auth::user();
        $courseIds = Course::where('teacher_id', $teacher->id)->pluck('id');
        
        // Get all enrollments for teacher's courses
        $enrollments = Enrollment::with(['student', 'course'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->paginate(15);
        
        // Get all courses for the filter dropdown
        $courses = Course::where('teacher_id', $teacher->id)->get();

        return view('instructor.students.index', compact('enrollments', 'courses'));
    }

    public function classes()
    {
        $teacher = Auth::user();
        $courseIds = Course::where('teacher_id', $teacher->id)->pluck('id');
        
        $classes = OnlineClass::with('course')
            ->whereIn('course_id', $courseIds)
            ->latest('scheduled_at')
            ->paginate(10);

        return view('instructor.classes.index', compact('classes'));
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

        return redirect()->route('instructor.dashboard')
            ->with('success', 'Profile updated successfully');
    }
}
