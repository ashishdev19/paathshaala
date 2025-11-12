<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineClass;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OnlineClass::with(['course', 'course.teacher']);

        // Apply filters
        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'upcoming') {
                $query->where('scheduled_at', '>', now());
            } elseif ($request->status === 'live') {
                $query->where('scheduled_at', '<=', now())
                      ->where('scheduled_at', '>=', now()->subMinutes(60));
            } elseif ($request->status === 'completed') {
                $query->where('scheduled_at', '<', now()->subHours(2));
            }
        }

        if ($request->has('course_id') && $request->course_id !== 'all') {
            $query->where('course_id', $request->course_id);
        }

        $classes = $query->orderBy('scheduled_at', 'desc')->paginate(15);

        // Get courses for filter dropdown
        $courses = Course::all();

        return view('admin.online-classes.index', compact('classes', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.online-classes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules for creating new course and class
        $rules = [
            'course_title' => 'required|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'course_description' => 'nullable|string',
            'course_category' => 'nullable|string|max:100',
            'course_level' => 'nullable|in:beginner,intermediate,advanced',
            'course_price' => 'nullable|numeric|min:0',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live,recorded',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_id' => 'nullable|string',
            'meeting_password' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:1048576',
            'video_url' => 'nullable|url',
        ];

        $request->validate($rules);

        DB::beginTransaction();

        try {
            // Always create new course
            $courseData = [
                'title' => $request->course_title,
                'description' => $request->course_description,
                'category' => $request->course_category,
                'level' => $request->course_level,
                'price' => $request->course_price ?? 0,
                'teacher_id' => $request->teacher_id,
                'is_active' => true
            ];
            
            $course = Course::create($courseData);
            $courseId = $course->id;

            $data = $request->only([
                'title', 'description', 'type',
                'scheduled_at', 'duration_minutes', 'meeting_link',
                'meeting_id', 'meeting_password'
            ]);
            
            $data['course_id'] = $courseId;

            // Handle video upload for recorded classes
            if ($request->type === 'recorded' && $request->hasFile('video_file')) {
                $video = $request->file('video_file');
                $filename = time() . '_' . \Illuminate\Support\Str::slug($request->title) . '.' . $video->getClientOriginalExtension();
                $path = $video->storeAs('videos/classes', $filename, 'public');
                $data['video_url'] = \Illuminate\Support\Facades\Storage::url($path);
            } elseif ($request->type === 'recorded' && $request->video_url) {
                $data['video_url'] = $request->video_url;
            }

            // Auto-generate meeting details for live classes if not provided
            if ($request->type === 'live' && !$request->meeting_id) {
                $data['meeting_id'] = 'CLASS-' . strtoupper(\Illuminate\Support\Str::random(8));
                if (!$request->meeting_password) {
                    $data['meeting_password'] = \Illuminate\Support\Str::random(6);
                }
            }

            // Set order
            $maxOrder = OnlineClass::where('course_id', $courseId)->max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
            $data['is_active'] = true;

            $onlineClass = OnlineClass::create($data);

            DB::commit();

            return redirect()->route('admin.online-classes.index')
                           ->with('success', 'Online class and course created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create online class. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(OnlineClass $onlineClass)
    {
        $onlineClass->load(['course', 'course.teacher', 'course.enrollments.student']);
        return view('admin.online-classes.show', compact('onlineClass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnlineClass $onlineClass)
    {
        $courses = Course::all();
        return view('admin.online-classes.edit', compact('onlineClass', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OnlineClass $onlineClass)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live,recorded',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_id' => 'nullable|string',
            'meeting_password' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:1048576',
            'video_url' => 'nullable|url',
            'is_active' => 'boolean',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->only([
                'title', 'description', 'type', 'scheduled_at',
                'duration_minutes', 'meeting_link', 'meeting_id',
                'meeting_password', 'is_active'
            ]);

            // Handle video upload for recorded classes
            if ($request->type === 'recorded' && $request->hasFile('video_file')) {
                // Delete old video if exists
                if ($onlineClass->video_url && \Illuminate\Support\Facades\Storage::disk('public')->exists(str_replace('/storage/', '', $onlineClass->video_url))) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $onlineClass->video_url));
                }

                $video = $request->file('video_file');
                $filename = time() . '_' . \Illuminate\Support\Str::slug($request->title) . '.' . $video->getClientOriginalExtension();
                $path = $video->storeAs('videos/classes', $filename, 'public');
                $data['video_url'] = \Illuminate\Support\Facades\Storage::url($path);
            } elseif ($request->type === 'recorded' && $request->video_url) {
                $data['video_url'] = $request->video_url;
            }

            $onlineClass->update($data);

            DB::commit();

            return redirect()->route('admin.online-classes.index')
                           ->with('success', 'Online class updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update online class. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OnlineClass $onlineClass)
    {
        try {
            // Delete associated video file if exists
            if ($onlineClass->video_url && \Illuminate\Support\Facades\Storage::disk('public')->exists(str_replace('/storage/', '', $onlineClass->video_url))) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete(str_replace('/storage/', '', $onlineClass->video_url));
            }

            $onlineClass->delete();

            return redirect()->route('admin.online-classes.index')
                           ->with('success', 'Online class deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete online class. Please try again.');
        }
    }
}
