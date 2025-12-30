<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\User;
use App\Models\Review;
use App\Models\Enrollment;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses = Course::active()
            ->withCount(['enrollments', 'reviews'])
            ->with(['teacher', 'reviews' => function ($query) {
                $query->latest()->limit(3);
            }])
            ->orderBy('enrollments_count', 'desc')
            ->limit(6)
            ->get();

        $stats = [
            'total_courses' => Course::active()->count(),
            'total_students' => User::byRole('student')->count(),
            'total_teachers' => User::byRole('instructor')->count(),
            'total_enrollments' => Enrollment::count(),
        ];

        $testimonials = Review::with(['student', 'course'])
            ->where('rating', '>=', 4)
            ->latest()
            ->limit(6)
            ->get();

        $categories = CourseCategory::active()
            ->showOnHomepage()
            ->withCount(['courses' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('display_order')
            ->orderBy('name')
            ->limit(12)
            ->get();

        $subscriptionPlans = SubscriptionPlan::active()
            ->ordered()
            ->get();

        return view('welcome', compact('featuredCourses', 'stats', 'testimonials', 'categories', 'subscriptionPlans'));
    }

    public function courses()
    {
        $courses = Course::active()
            ->withCount(['enrollments', 'reviews'])
            ->with(['teacher', 'reviews'])
            ->paginate(12);

        return view('admin.courses.public-index', compact('courses'));
    }

    public function courseDetail($id)
    {
        $course = Course::active()
            ->withCount(['enrollments', 'reviews'])
            ->with(['teacher', 'reviews.student', 'onlineClasses'])
            ->findOrFail($id);

        $relatedCourses = Course::active()
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->withCount('enrollments')
            ->limit(4)
            ->get();

        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Auth::user()->enrollments()
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('courses.show', compact('course', 'relatedCourses', 'isEnrolled'));
    }

    public function about()
    {
        $teachers = User::byRole('instructor')
            ->with(['teacherCourses' => function ($query) {
                $query->where('status', 'active');
            }])
            ->withCount(['teacherCourses as active_courses_count' => function ($query) {
                $query->where('status', 'active');
            }])
            ->having('active_courses_count', '>', 0)
            ->limit(8)
            ->get();

        return view('shared.public.about', compact('teachers'));
    }

    public function contact()
    {
        return view('shared.public.contact');
    }
}