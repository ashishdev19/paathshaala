<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class CheckCourseAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get course ID from route parameter
        $courseId = $request->route('id') ?? $request->route('course');
        
        if (!$courseId) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Course not found.');
        }

        // Get the course
        $course = Course::find($courseId);
        if (!$course) {
            return redirect()->route('student.dashboard')
                ->with('error', 'Course not found.');
        }

        // Check if user is enrolled
        $enrollment = Enrollment::where('student_id', Auth::id())
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            return redirect()->route('student.courses.preview', $courseId)
                ->with('error', 'You are not enrolled in this course.');
        }

        // Check if enrollment has expired
        if ($enrollment->isExpired()) {
            return redirect()->route('student.courses.preview', $courseId)
                ->with('error', 'Your access to this course has expired. Please renew your subscription.');
        }

        // Check if enrollment has access
        if (!$enrollment->hasAccess()) {
            return redirect()->route('student.courses.preview', $courseId)
                ->with('error', 'You do not have access to this course.');
        }

        return $next($request);
    }
}
