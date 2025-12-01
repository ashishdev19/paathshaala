<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $user = Auth::user();
        $hasSubscription = $user && $user->currentSubscription()->exists();

        return view('instructor.courses.create', [
            'hasSubscription' => $hasSubscription,
            'currentSubscription' => $user ? $user->currentSubscription()->first() : null,
        ]);
    }

    /**
     * Store a newly created course in storage.
     */
    public function store(Request $request)
    {
        // Ensure teacher has active subscription before allowing course creation
        $user = Auth::user();
        $hasSubscription = $user && $user->currentSubscription()->exists();
        if (!$hasSubscription) {
            return redirect()->route('instructor.courses.create')
                ->with('error', 'Please subscribe to a plan to create a course.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:draft,published,archived',
            'thumbnail' => 'nullable|image|max:5120',
            'syllabus_pdf' => 'nullable|mimes:pdf|max:20480',
            'video_file' => 'nullable|mimes:mp4,mov,avi,mkv,webm|max:1048576',
            'video_url' => 'nullable|url',
        ]);

        $course = new Course();
        $course->title = $validated['title'];
        $course->description = $validated['description'] ?? null;
        $course->category = $validated['category'] ?? 'General';
        $course->price = $validated['price'] ?? 0;
        $course->status = $validated['status'] ?? 'draft';
        $course->teacher_id = Auth::id();

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $course->thumbnail = $path;
        }

        // Handle syllabus PDF upload (store path in syllabus json)
        if ($request->hasFile('syllabus_pdf')) {
            $pdfPath = $request->file('syllabus_pdf')->store('courses/syllabi', 'public');
            $course->syllabus = ['pdf' => $pdfPath];
        }

        // Handle video file upload or URL
        if ($request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('courses/videos', 'public');
            $course->video_file = $videoPath;
        }

        if (!empty($validated['video_url'])) {
            $course->video_url = $validated['video_url'];
        }

        $course->save();

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course created successfully');
    }

    /**
     * Display the specified course.
     */
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('instructor.courses.show', ['course' => $course]);
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }
        return view('instructor.courses.edit', ['courseModel' => $course]);
    }

    /**
     * Update the specified course in storage.
     */
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'status' => 'nullable|in:draft,published,archived',
            'thumbnail' => 'nullable|image|max:5120',
            'syllabus_pdf' => 'nullable|mimes:pdf|max:20480',
            'video_file' => 'nullable|mimes:mp4,mov,avi,mkv,webm|max:1048576',
            'video_url' => 'nullable|url',
        ]);

        $course->title = $validated['title'];
        $course->description = $validated['description'] ?? $course->description;
        $course->category = $validated['category'] ?? $course->category;
        $course->price = $validated['price'] ?? $course->price;
        $course->status = $validated['status'] ?? $course->status;
        
        // Handle thumbnail upload (replace)
        if ($request->hasFile('thumbnail')) {
            if (!empty($course->thumbnail) && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $path = $request->file('thumbnail')->store('courses/thumbnails', 'public');
            $course->thumbnail = $path;
        }

        // Handle syllabus PDF upload (replace)
        if ($request->hasFile('syllabus_pdf')) {
            if (!empty($course->syllabus['pdf']) && Storage::disk('public')->exists($course->syllabus['pdf'])) {
                Storage::disk('public')->delete($course->syllabus['pdf']);
            }
            $pdfPath = $request->file('syllabus_pdf')->store('courses/syllabi', 'public');
            $course->syllabus = ['pdf' => $pdfPath];
        }

        // Handle video file upload or URL
        if ($request->hasFile('video_file')) {
            if (!empty($course->video_file) && Storage::disk('public')->exists($course->video_file)) {
                Storage::disk('public')->delete($course->video_file);
            }
            $videoPath = $request->file('video_file')->store('courses/videos', 'public');
            $course->video_file = $videoPath;
        }

        if (!empty($validated['video_url'])) {
            $course->video_url = $validated['video_url'];
        }

        $course->save();

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified course from storage.
     */
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->teacher_id != Auth::id()) {
            abort(403);
        }
        $course->delete();

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
