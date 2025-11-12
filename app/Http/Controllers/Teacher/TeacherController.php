<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\OnlineClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
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

        return view('teacher.dashboard', compact(
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

        return view('teacher.courses.index', compact('courses'));
    }

    public function students()
    {
        $teacher = Auth::user();
        $courseIds = Course::where('teacher_id', $teacher->id)->pluck('id');
        
        $students = User::role('student')
            ->whereHas('enrollments', function($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds);
            })
            ->with(['enrollments' => function($query) use ($courseIds) {
                $query->whereIn('course_id', $courseIds)->with('course');
            }])
            ->paginate(15);

        return view('teacher.students.index', compact('students'));
    }

    public function classes()
    {
        $teacher = Auth::user();
        $courseIds = Course::where('teacher_id', $teacher->id)->pluck('id');
        
        $classes = OnlineClass::with('course')
            ->whereIn('course_id', $courseIds)
            ->latest('scheduled_at')
            ->paginate(10);

        return view('teacher.classes.index', compact('classes'));
    }
}
