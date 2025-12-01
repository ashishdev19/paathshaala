<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessorDashboardController extends Controller
{
    /**
     * Display the professor dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get professor's statistics
        // Try different relationship names
        $userCourses = $user->courses ?? $user->createdCourses ?? collect();
        
        $stats = [
            'courses' => is_countable($userCourses) ? count($userCourses) : 0,
            'students' => Enrollment::count(), // Simplified for now
            'enrollments' => Enrollment::count(),
            'active_courses' => 0,
            'modules' => 0,
            'pending' => 0,
        ];

        return view('professor.dashboard', compact('stats'));
    }

    /**
     * View all professor's courses
     */
    public function courses()
    {
        $courses = Course::paginate(10);
        return view('professor.courses', compact('courses'));
    }

    /**
     * View students enrolled in professor's courses
     */
    public function students()
    {
        $students = Enrollment::with('student')->paginate(10);
        return view('professor.students', compact('students'));
    }
}
