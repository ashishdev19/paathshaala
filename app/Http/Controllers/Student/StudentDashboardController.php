<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    /**
     * Display the student dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get student's statistics
        $stats = [
            'enrolled_courses' => Enrollment::count(),
            'in_progress' => 0,
            'completed' => 0,
            'avg_progress' => 0,
            'streak' => 5,
        ];

        return view('student.dashboard', compact('stats'));
    }

    /**
     * View all enrolled courses
     */
    public function courses()
    {
        $courses = Course::paginate(10);
        return view('student.courses', compact('courses'));
    }

    /**
     * View course progress
     */
    public function progress($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('student.progress', compact('course'));
    }

    /**
     * Explore all available courses
     */
    public function explore()
    {
        $courses = Course::where('status', 'active')->paginate(12);
        return view('student.explore', compact('courses'));
    }
}
