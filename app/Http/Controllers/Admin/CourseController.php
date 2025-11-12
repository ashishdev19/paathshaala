<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['enrollments', 'teacher'])
            ->withCount(['enrollments', 'reviews'])
            ->latest()
            ->paginate(12);
            
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $teachers = User::role('teacher')->get();
        return view('admin.courses.create', compact('teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'teacher_id' => ['required', 'exists:users,id'],
            'category' => ['required', 'string', 'max:100'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $courseData = $request->all();
        $courseData['slug'] = Str::slug($request->title);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $courseData['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        Course::create($courseData);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['enrollments.user', 'reviews.user', 'teacher']);
        
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $teachers = User::role('teacher')->get();
        return view('admin.courses.edit', compact('course', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'duration' => ['required', 'integer', 'min:1'],
            'level' => ['required', 'in:beginner,intermediate,advanced'],
            'teacher_id' => ['required', 'exists:users,id'],
            'category' => ['required', 'string', 'max:100'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $courseData = $request->all();
        $courseData['slug'] = Str::slug($request->title);

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $courseData['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($courseData);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Delete thumbnail if exists
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
