<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class LandingPageController extends Controller
{
    public function index()
    {
        $featuredCourses = Course::where('is_active', true)
            ->where('is_featured', true)
            ->with('teacher')
            ->take(6)
            ->get();

        $popularCourses = Course::where('is_active', true)
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->with('teacher')
            ->take(6)
            ->get();

        return view('welcome', compact('featuredCourses', 'popularCourses'));
    }

    public function courseDetail($id)
    {
        $course = Course::with(['teacher', 'enrollments', 'reviews'])
            ->findOrFail($id);
            
        return response()->json([
            'course' => $course,
            'enrollment_count' => $course->enrollments->count(),
            'average_rating' => $course->reviews->avg('rating'),
            'reviews_count' => $course->reviews->count()
        ]);
    }
}
