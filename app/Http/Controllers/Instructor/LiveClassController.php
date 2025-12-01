<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LiveClassController extends Controller
{
    /**
     * Display a listing of live classes
     */
    public function index()
    {
        $liveClasses = LiveClass::where('instructor_id', auth()->id())
            ->with('course')
            ->orderBy('start_datetime', 'desc')
            ->paginate(10);

        return view('instructor.live-classes.index', compact('liveClasses'));
    }

    /**
     * Show the form for creating a new live class
     */
    public function create()
    {
        $courses = Course::where('teacher_id', auth()->id())
            ->where('status', 'published')
            ->get();

        return view('instructor.live-classes.create', compact('courses'));
    }

    /**
     * Store a newly created live class
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mode' => 'required|in:online,offline,hybrid',
            'date' => 'required|date',
            'time' => 'required',
            'duration' => 'required|integer|min:15|max:480',
            'allow_chat' => 'boolean',
            'allow_mic' => 'boolean',
            'allow_video' => 'boolean',
        ]);

        // Generate unique room name
        $roomName = 'class-' . Str::random(12);
        
        // Create Jitsi meeting link
        $meetingLink = "https://meet.jit.si/" . $roomName;

        // Combine date and time
        $startDatetime = Carbon::parse($validated['date'] . ' ' . $validated['time']);

        // Create live class
        $liveClass = LiveClass::create([
            'instructor_id' => auth()->id(),
            'course_id' => $validated['course_id'] ?? null,
            'topic' => $validated['topic'],
            'description' => $validated['description'] ?? null,
            'mode' => $validated['mode'],
            'room_name' => $roomName,
            'meeting_link' => $meetingLink,
            'start_datetime' => $startDatetime,
            'duration' => $validated['duration'],
            'allow_chat' => $request->has('allow_chat'),
            'allow_mic' => $request->has('allow_mic'),
            'allow_video' => $request->has('allow_video'),
            'status' => 'scheduled',
        ]);

        return redirect()
            ->route('instructor.live-classes.index')
            ->with('success', 'Live class scheduled successfully!');
    }

    /**
     * Join the live class (Jitsi room)
     */
    public function join($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        // Check if user is the instructor
        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Update status to live if it's the first time joining
        if ($liveClass->status === 'scheduled' && $liveClass->hasStarted()) {
            $liveClass->update(['status' => 'live']);
        }

        return view('instructor.live-classes.join', compact('liveClass'));
    }

    /**
     * End the live class
     */
    public function end($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $liveClass->update(['status' => 'ended']);

        return redirect()
            ->route('instructor.live-classes.index')
            ->with('success', 'Live class ended successfully!');
    }

    /**
     * Cancel the live class
     */
    public function cancel($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $liveClass->update(['status' => 'cancelled']);

        return redirect()
            ->route('instructor.live-classes.index')
            ->with('success', 'Live class cancelled successfully!');
    }

    /**
     * Show live class details
     */
    public function show($id)
    {
        $liveClass = LiveClass::with('course')->findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.live-classes.show', compact('liveClass'));
    }

    /**
     * Show the form for editing a live class
     */
    public function edit($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $courses = Course::where('teacher_id', auth()->id())
            ->where('status', 'published')
            ->get();

        return view('instructor.live-classes.edit', compact('liveClass', 'courses'));
    }

    /**
     * Update live class details
     */
    public function update(Request $request, $id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'topic' => 'required|string|max:255',
            'description' => 'nullable|string',
            'mode' => 'required|in:online,offline,hybrid',
            'duration' => 'required|integer|min:15|max:480',
        ]);

        $liveClass->update($validated);

        return redirect()
            ->route('instructor.live-classes.index')
            ->with('success', 'Live class updated successfully!');
    }

    /**
     * Show reschedule form
     */
    public function reschedule($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.live-classes.reschedule', compact('liveClass'));
    }

    /**
     * Update reschedule
     */
    public function updateReschedule(Request $request, $id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);

        $startDatetime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $liveClass->update(['start_datetime' => $startDatetime]);

        return redirect()
            ->route('instructor.live-classes.index')
            ->with('success', 'Live class rescheduled successfully!');
    }

    /**
     * Share invite link
     */
    public function shareInvite($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.live-classes.share-invite', compact('liveClass'));
    }

    /**
     * View attendance
     */
    public function attendance($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        return view('instructor.live-classes.attendance', compact('liveClass'));
    }

    /**
     * Delete a live class
     */
    public function destroy($id)
    {
        $liveClass = LiveClass::findOrFail($id);

        if ($liveClass->instructor_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $liveClass->delete();

        return redirect()->route('instructor.live-classes.index')
                       ->with('success', 'Live class deleted successfully!');
    }
}