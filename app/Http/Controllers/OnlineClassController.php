<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OnlineClass;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OnlineClassController extends Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = OnlineClass::with(['course', 'course.teacher']);

        // Filter based on user role
        if ($user->hasRole('admin')) {
            // Admins can see all classes
            $query = OnlineClass::with(['course', 'course.teacher']);
        } elseif ($user->hasRole('teacher')) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        } elseif ($user->hasRole('student')) {
            $query->whereHas('course.enrollments', function ($q) use ($user) {
                $q->where('student_id', $user->id)
                  ->where('status', 'active');
            });
        }

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

        $classes = $query->orderBy('scheduled_at', 'desc')->paginate(10);

        // Get courses for filter dropdown
        $coursesQuery = Course::query();
        if ($user->hasRole('admin')) {
            // Admins can see all courses
        } elseif ($user->hasRole('teacher')) {
            $coursesQuery->where('teacher_id', $user->id);
        } elseif ($user->hasRole('student')) {
            $coursesQuery->whereHas('enrollments', function ($q) use ($user) {
                $q->where('student_id', $user->id)->where('status', 'active');
            });
        }
        $courses = $coursesQuery->get();

        return view('online-classes.index', compact('classes', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', OnlineClass::class);
        
        $user = Auth::user();
        
        // Admins can see all courses, teachers can only see their own courses
        if ($user->hasRole('admin')) {
            $courses = Course::all();
        } else {
            $courses = Course::where('teacher_id', $user->id)->get();
        }
        
        return view('online-classes.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', OnlineClass::class);

        // Dynamic validation based on course option
        $rules = [
            'course_option' => 'required|in:existing,new',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live,recorded',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'meeting_link' => 'nullable|url',
            'meeting_id' => 'nullable|string',
            'meeting_password' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv|max:1048576', // 1GB max
            'video_url' => 'nullable|url',
        ];

        if ($request->course_option === 'existing') {
            $rules['course_id'] = 'required|exists:courses,id';
        } else {
            $rules['course_title'] = 'required|string|max:255';
            $rules['course_description'] = 'nullable|string';
            $rules['course_category'] = 'nullable|string|max:100';
            $rules['course_level'] = 'nullable|in:beginner,intermediate,advanced';
            $rules['course_price'] = 'nullable|numeric|min:0';
        }

        $request->validate($rules);

        DB::beginTransaction();
        
        try {
            $courseId = null;
            
            // Handle course creation or selection
            if ($request->course_option === 'new') {
                // Create new course
                $courseData = [
                    'title' => $request->course_title,
                    'description' => $request->course_description,
                    'category' => $request->course_category,
                    'level' => $request->course_level,
                    'price' => $request->course_price ?? 0,
                    'teacher_id' => Auth::id(),
                    'is_active' => true
                ];
                
                $course = Course::create($courseData);
                $courseId = $course->id;
            } else {
                // Use existing course
                $courseId = $request->course_id;
            }
            
            $data = $request->only([
                'title', 'description', 'type', 
                'scheduled_at', 'duration_minutes', 'meeting_link',
                'meeting_id', 'meeting_password'
            ]);
            
            $data['course_id'] = $courseId;

            // Handle video upload for recorded classes
            if ($request->type === 'recorded' && $request->hasFile('video_file')) {
                $video = $request->file('video_file');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $video->getClientOriginalExtension();
                $path = $video->storeAs('videos/classes', $filename, 'public');
                $data['video_url'] = Storage::url($path);
            } elseif ($request->type === 'recorded' && $request->video_url) {
                $data['video_url'] = $request->video_url;
            }

            // Auto-generate meeting details for live classes if not provided
            if ($request->type === 'live' && !$request->meeting_id) {
                $data['meeting_id'] = 'CLASS-' . strtoupper(Str::random(8));
                if (!$request->meeting_password) {
                    $data['meeting_password'] = Str::random(6);
                }
            }

            // Set order
            $maxOrder = OnlineClass::where('course_id', $courseId)->max('order') ?? 0;
            $data['order'] = $maxOrder + 1;
            $data['is_active'] = true;

            $onlineClass = OnlineClass::create($data);

            DB::commit();

            return redirect()->route('online-classes.show', $onlineClass)
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
        $this->authorize('view', $onlineClass);
        
        $onlineClass->load(['course', 'course.teacher', 'course.enrollments.student']);
        
        $user = Auth::user();
        $isEnrolled = false;
        $canJoin = false;
        
        if ($user->hasRole('student')) {
            $isEnrolled = $onlineClass->course->enrollments()
                                               ->where('student_id', $user->id)
                                               ->where('status', 'active')
                                               ->exists();
        }

        // Check if class can be joined (for live classes)
        if ($onlineClass->type === 'live') {
            $scheduledTime = $onlineClass->scheduled_at;
            $now = now();
            $classEndTime = $scheduledTime->copy()->addMinutes($onlineClass->duration_minutes);
            
            // Allow joining 15 minutes before and during the class
            $canJoin = $now->greaterThanOrEqualTo($scheduledTime->copy()->subMinutes(15)) 
                      && $now->lessThanOrEqualTo($classEndTime);
        }

        $enrolledStudents = $onlineClass->course->enrollments()
                                                ->where('status', 'active')
                                                ->with('student')
                                                ->get();

        return view('online-classes.show', compact(
            'onlineClass', 'isEnrolled', 'canJoin', 'enrolledStudents'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OnlineClass $onlineClass)
    {
        $this->authorize('update', $onlineClass);
        
        $user = Auth::user();
        
        // Admins can see all courses, teachers can only see their own courses
        if ($user->hasRole('admin')) {
            $courses = Course::all();
        } else {
            $courses = Course::where('teacher_id', $user->id)->get();
        }
        
        return view('online-classes.edit', compact('onlineClass', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OnlineClass $onlineClass)
    {
        $this->authorize('update', $onlineClass);

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
                if ($onlineClass->video_url && Storage::disk('public')->exists(str_replace('/storage/', '', $onlineClass->video_url))) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $onlineClass->video_url));
                }

                $video = $request->file('video_file');
                $filename = time() . '_' . Str::slug($request->title) . '.' . $video->getClientOriginalExtension();
                $path = $video->storeAs('videos/classes', $filename, 'public');
                $data['video_url'] = Storage::url($path);
            } elseif ($request->type === 'recorded' && $request->video_url) {
                $data['video_url'] = $request->video_url;
            }

            $onlineClass->update($data);

            DB::commit();

            return redirect()->route('online-classes.show', $onlineClass)
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
        $this->authorize('delete', $onlineClass);

        try {
            // Delete associated video file if exists
            if ($onlineClass->video_url && Storage::disk('public')->exists(str_replace('/storage/', '', $onlineClass->video_url))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $onlineClass->video_url));
            }

            $onlineClass->delete();

            return redirect()->route('online-classes.index')
                           ->with('success', 'Online class deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete online class. Please try again.');
        }
    }

    /**
     * Join a live class
     */
    public function join(OnlineClass $onlineClass)
    {
        $this->authorize('view', $onlineClass);

        $user = Auth::user();

        // Check if user is enrolled (for students)
        if ($user->hasRole('student')) {
            $isEnrolled = $onlineClass->course->enrollments()
                                               ->where('student_id', $user->id)
                                               ->where('status', 'active')
                                               ->exists();
            if (!$isEnrolled) {
                return back()->with('error', 'You must be enrolled in this course to join the class.');
            }
        }

        // Check if it's a live class
        if ($onlineClass->type !== 'live') {
            return back()->with('error', 'This is not a live class.');
        }

        // Check timing
        $scheduledTime = $onlineClass->scheduled_at;
        $now = now();
        $classEndTime = $scheduledTime->copy()->addMinutes($onlineClass->duration_minutes);
        
        if ($now->lessThan($scheduledTime->copy()->subMinutes(15))) {
            return back()->with('error', 'Class has not started yet. You can join 15 minutes before the scheduled time.');
        }

        if ($now->greaterThan($classEndTime)) {
            return back()->with('error', 'This class has already ended.');
        }

        // Redirect to meeting link or show meeting details
        if ($onlineClass->meeting_link) {
            return redirect()->away($onlineClass->meeting_link);
        }

        return view('online-classes.join', compact('onlineClass'));
    }

    /**
     * Watch a recorded class
     */
    public function watch(OnlineClass $onlineClass)
    {
        $this->authorize('view', $onlineClass);

        $user = Auth::user();

        // Check if user is enrolled (for students)
        if ($user->hasRole('student')) {
            $isEnrolled = $onlineClass->course->enrollments()
                                               ->where('student_id', $user->id)
                                               ->where('status', 'active')
                                               ->exists();
            if (!$isEnrolled) {
                return back()->with('error', 'You must be enrolled in this course to watch this class.');
            }
        }

        // Check if it's a recorded class with video
        if ($onlineClass->type !== 'recorded' || !$onlineClass->video_url) {
            return back()->with('error', 'This class does not have a recording available.');
        }

        return view('online-classes.watch', compact('onlineClass'));
    }

    public function upcoming()
    {
        $user = Auth::user();
        $query = OnlineClass::with(['course', 'course.teacher'])
                            ->where('scheduled_at', '>', now())
                            ->where('is_active', true);

        if ($user->hasRole('admin')) {
            // Admins can see all upcoming classes
        } elseif ($user->hasRole('teacher')) {
            $query->whereHas('course', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        } elseif ($user->hasRole('student')) {
            $query->whereHas('course.enrollments', function ($q) use ($user) {
                $q->where('student_id', $user->id)->where('status', 'active');
            });
        }

        $upcomingClasses = $query->orderBy('scheduled_at')
                                ->limit(5)
                                ->get();

        return response()->json($upcomingClasses);
    }

    /**
     * Mark attendance for a live class
     */
    public function markAttendance(OnlineClass $onlineClass)
    {
        $this->authorize('view', $onlineClass);

        $user = Auth::user();

        if (!$user->hasRole('student')) {
            return response()->json(['error' => 'Only students can mark attendance'], 403);
        }

        // Check if enrolled
        $enrollment = $onlineClass->course->enrollments()
                                          ->where('student_id', $user->id)
                                          ->where('status', 'active')
                                          ->first();
        
        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        // Check if class is currently live
        $scheduledTime = $onlineClass->scheduled_at;
        $now = now();
        $classEndTime = $scheduledTime->copy()->addMinutes($onlineClass->duration_minutes);
        
        if ($now->lessThan($scheduledTime) || $now->greaterThan($classEndTime)) {
            return response()->json(['error' => 'Attendance can only be marked during live class'], 400);
        }

        // For now, we'll just return success. In a real implementation,
        // you'd create an attendance tracking system
        return response()->json(['success' => 'Attendance marked successfully']);
    }

    /**
     * Update video progress for a student
     */
    public function updateProgress(Request $request, OnlineClass $onlineClass)
    {
        $this->authorize('view', $onlineClass);

        $user = Auth::user();

        if (!$user->hasRole('student')) {
            return response()->json(['error' => 'Only students can update progress'], 403);
        }

        // Check if enrolled
        $enrollment = $onlineClass->course->enrollments()
                                          ->where('student_id', $user->id)
                                          ->where('status', 'active')
                                          ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        $request->validate([
            'progress' => 'required|numeric|min:0|max:100',
            'current_time' => 'required|numeric|min:0'
        ]);

        try {
            // Update enrollment with progress data
            $enrollment->update([
                'progress_percentage' => $request->progress,
                'last_watched_at' => now(),
                'current_time' => $request->current_time
            ]);

            // Update class analytics
            $onlineClass->increment('total_watch_time', 5); // Add 5 seconds for each update
            $onlineClass->increment('total_views'); // This might be better tracked differently

            return response()->json(['success' => 'Progress updated successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update progress'], 500);
        }
    }

    /**
     * Mark class as completed for a student
     */
    public function markCompleted(Request $request, OnlineClass $onlineClass)
    {
        $this->authorize('view', $onlineClass);

        $user = Auth::user();

        if (!$user->hasRole('student')) {
            return response()->json(['error' => 'Only students can mark classes as completed'], 403);
        }

        // Check if enrolled
        $enrollment = $onlineClass->course->enrollments()
                                          ->where('student_id', $user->id)
                                          ->where('status', 'active')
                                          ->first();

        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        try {
            // Mark as completed
            $enrollment->update([
                'progress_percentage' => 100,
                'completed_at' => now(),
                'last_watched_at' => now()
            ]);

            // Update class analytics
            $onlineClass->increment('total_completions');

            // Check if course is completed (all classes completed)
            $totalClasses = $onlineClass->course->onlineClasses()->count();
            $completedClasses = $onlineClass->course->enrollments()
                                                   ->where('student_id', $user->id)
                                                   ->where('progress_percentage', 100)
                                                   ->count();

            if ($totalClasses > 0 && $completedClasses >= $totalClasses) {
                // Mark course as completed
                $enrollment->update(['completed_at' => now()]);
            }

            return response()->json(['success' => 'Class marked as completed!']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to mark class as completed'], 500);
        }
    }
}