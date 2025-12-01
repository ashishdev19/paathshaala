<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LiveClassController extends Controller
{
    /**
     * Display available and upcoming live classes
     */
    public function index()
    {
        $studentId = auth()->id();

        // Get enrolled course IDs
        $enrolledCourseIds = Enrollment::where('student_id', $studentId)
            ->pluck('course_id')
            ->toArray();

        // Get live classes for enrolled courses or general sessions
        $liveClasses = LiveClass::with(['course', 'instructor'])
            ->where(function($query) use ($enrolledCourseIds) {
                $query->whereIn('course_id', $enrolledCourseIds)
                      ->orWhereNull('course_id'); // General sessions
            })
            ->whereIn('status', ['scheduled', 'live'])
            ->orderBy('start_datetime', 'asc')
            ->paginate(10);

        return view('student.live-classes.index', compact('liveClasses'));
    }

    /**
     * Join a live class
     */
    public function join($id)
    {
        $liveClass = LiveClass::with(['course', 'instructor'])->findOrFail($id);
        $studentId = auth()->id();

        // Check if class is available to join
        if (!in_array($liveClass->status, ['scheduled', 'live'])) {
            return redirect()
                ->route('student.live-classes.index')
                ->with('error', 'This class has ended or been cancelled.');
        }

        // Check enrollment if course-specific
        if ($liveClass->course_id) {
            $isEnrolled = Enrollment::where('student_id', $studentId)
                ->where('course_id', $liveClass->course_id)
                ->exists();

            if (!$isEnrolled) {
                return redirect()
                    ->route('student.live-classes.index')
                    ->with('error', 'You must be enrolled in this course to join the class.');
            }
        }

        // Check if class is scheduled for today or is already live
        $classDate = $liveClass->start_datetime->startOfDay();
        $today = now()->startOfDay();
        
        if ($today->lessThan($classDate)) {
            return redirect()
                ->route('student.live-classes.index')
                ->with('error', 'This class will be available on ' . $liveClass->start_datetime->format('M d, Y'));
        }

        return view('student.live-classes.join', compact('liveClass'));
    }
}
