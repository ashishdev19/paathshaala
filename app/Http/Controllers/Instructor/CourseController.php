<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Http\Requests\Instructor\StoreCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CourseCategory::active()
            ->orderBy('name')
            ->get();

        // Check if there are active categories
        if ($categories->isEmpty()) {
            return redirect()
                ->back()
                ->with('error', 'No active categories available. Please contact the administrator.');
        }

        return view('instructor.courses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $data = $request->validated();
            
            // Add instructor/teacher ID
            $data['teacher_id'] = Auth::id();
            
            // Generate slug from title
            $data['slug'] = Str::slug($data['title']);
            
            // Set default status
            $data['status'] = 'pending'; // Pending admin approval
            $data['is_active'] = false;
            
            // Create course first to get the ID
            $course = Course::create($data);
            
            // Handle thumbnail upload - Store as file path for better performance
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                
                // Generate a unique filename
                $filename = 'course_' . $course->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Store in public disk under courses/thumbnails
                $path = $file->storeAs('courses/thumbnails', $filename, 'public');
                
                // Store the path (without 'storage/' prefix - the accessor will handle URL generation)
                $course->thumbnail = $path;
                $course->save();
            }

            return redirect()
                ->route('instructor.courses.index')
                ->with('success', 'Course created successfully and sent for admin approval.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create course: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Ensure instructor can only view their own courses
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $course->load('category', 'sections', 'enrollments');
        return view('instructor.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // Ensure instructor can only edit their own courses
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = CourseCategory::active()
            ->orderBy('name')
            ->get();

        return view('instructor.courses.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCourseRequest $request, Course $course)
    {
        // Ensure instructor can only update their own courses
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $data = $request->validated();
            
            // Update slug if title changed
            if ($data['title'] !== $course->title) {
                $data['slug'] = Str::slug($data['title']);
            }
            
            // Handle thumbnail upload - Store as file path for better performance
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                
                // Generate a unique filename
                $filename = 'course_' . $course->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Store in public disk under courses/thumbnails
                $path = $file->storeAs('courses/thumbnails', $filename, 'public');
                
                // Delete old thumbnail if it was a file path (not base64)
                if ($course->thumbnail && strpos($course->thumbnail, 'data:image/') === false) {
                    \Storage::disk('public')->delete($course->thumbnail);
                }
                
                // Store the path (without 'storage/' prefix - the accessor will handle URL generation)
                $data['thumbnail'] = $path;
            }

            $course->update($data);

            return redirect()
                ->route('instructor.courses.index')
                ->with('success', 'Course updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update course: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Ensure instructor can only delete their own courses
        if ($course->teacher_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Delete thumbnail if exists
            if ($course->thumbnail) {
                \Storage::disk('public')->delete($course->thumbnail);
            }

            $course->delete();

            return redirect()
                ->route('instructor.courses.index')
                ->with('success', 'Course deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete course: ' . $e->getMessage());
        }
    }
}
