<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCourseApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $courses = Course::where('status', 'under_review')
            ->with('teacher')
            ->latest()
            ->paginate(15);

        $stats = [
            'pending' => Course::where('status', 'under_review')->count(),
            'published' => Course::where('status', 'published')->count(),
            'rejected' => Course::where('status', 'rejected')->count(),
        ];

        return view('admin.courses.index', compact('courses', 'stats'));
    }

    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function approve(Request $request, Course $course)
    {
        if ($course->status !== 'under_review') {
            return back()->with('error', 'This course cannot be approved!');
        }

        $course->update([
            'status' => 'published',
            'approved_by' => Auth::id(),
            'is_active' => true,
        ]);

        // Send notification to teacher
        // Notification::send($course->teacher, new CourseApprovedNotification($course));

        return back()->with('success', 'Course approved successfully!');
    }

    public function reject(Request $request, Course $course)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        if ($course->status !== 'under_review') {
            return back()->with('error', 'This course cannot be rejected!');
        }

        $course->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'is_active' => false,
        ]);

        // Send notification to teacher
        // Notification::send($course->teacher, new CourseRejectedNotification($course));

        return back()->with('success', 'Course rejected successfully!');
    }

    public function requestChanges(Request $request, Course $course)
    {
        $validated = $request->validate([
            'change_message' => 'required|string|min:10',
        ]);

        $course->update([
            'status' => 'draft',
            'rejection_reason' => $validated['change_message'],
        ]);

        return back()->with('success', 'Changes requested successfully!');
    }
}
