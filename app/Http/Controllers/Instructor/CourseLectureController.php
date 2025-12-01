<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseLectureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_id' => 'required|exists:course_sections,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf,quiz,assignment,live',
            'file_path' => 'nullable|file|max:51200',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|integer|min:0',
            'is_preview' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $section = CourseSection::findOrFail($validated['section_id']);
        $course = $section->course;

        $this->authorize('update', $course);

        $maxOrder = CourseLecture::where('section_id', $section->id)->max('order') ?? 0;

        $lecture = new CourseLecture();
        $lecture->section_id = $section->id;
        $lecture->title = $validated['title'];
        $lecture->type = $validated['type'];
        $lecture->is_preview = $validated['is_preview'] ?? false;
        $lecture->description = $validated['description'] ?? null;
        $lecture->duration = $validated['duration'] ?? null;
        $lecture->order = $maxOrder + 1;

        // Handle file upload
        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('courses/lectures', 'public');
            $lecture->file_path = 'storage/' . $path;
        }

        // Handle video URL
        if ($request->filled('video_url')) {
            $lecture->video_url = $validated['video_url'];
        }

        $lecture->save();

        return response()->json([
            'success' => true,
            'lecture' => $lecture,
            'message' => 'Lecture added successfully!',
        ]);
    }

    public function update(Request $request, CourseLecture $lecture)
    {
        $this->authorize('update', $lecture->section->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf,quiz,assignment,live',
            'video_url' => 'nullable|url',
            'duration' => 'nullable|integer|min:0',
            'is_preview' => 'boolean',
            'description' => 'nullable|string',
        ]);

        $lecture->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lecture updated successfully!',
        ]);
    }

    public function destroy(CourseLecture $lecture)
    {
        $this->authorize('delete', $lecture->section->course);

        $lecture->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lecture deleted successfully!',
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'lectures' => 'required|array',
            'lectures.*.id' => 'required|exists:course_lectures,id',
            'lectures.*.order' => 'required|integer',
        ]);

        foreach ($validated['lectures'] as $lecture) {
            CourseLecture::where('id', $lecture['id'])->update(['order' => $lecture['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lectures reordered successfully!',
        ]);
    }
}
