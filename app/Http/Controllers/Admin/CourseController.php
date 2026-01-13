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
    public function index(Request $request)
    {
        $query = Course::with(['enrollments', 'teacher'])
            ->withCount(['enrollments', 'reviews']);

        // Apply Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('teacher', function($t) use ($search) {
                      $t->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply Teacher Filter
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $courses = $query->latest()->paginate(12)->withQueryString();
            
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin cannot create courses, only professors can
        return redirect()->route('admin.courses.index')
            ->with('info', 'Courses are created by professors. You can manage existing courses here.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('Course store method called', ['data' => $request->all()]);
        
        try {
            $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
                'price' => ['required', 'numeric', 'min:0'],
                'duration' => ['required', 'integer', 'min:1'],
                'level' => ['required', 'in:beginner,intermediate,advanced'],
                'teacher_id' => ['required', 'exists:users,id'],
                'category' => ['required', 'string', 'max:100'],
                'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:200'],
                'video_file' => ['nullable', 'file', 'mimes:mp4,avi,mov,wmv,flv', 'max:102400'], // 100MB max
                'video_url' => ['nullable', 'url'],
                'is_featured' => ['boolean'],
                'status' => ['required', 'in:draft,published,archived'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            throw $e;
        }

        $courseData = $request->all();
        $courseData['slug'] = Str::slug($request->title);
        $courseData['duration_hours'] = $request->duration;

        // Create course first to get the ID
        $course = Course::create($courseData);
        
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

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $course->video_file = $request->file('video_file')->store('courses/videos', 'public');
            $course->save();
        }

        // Handle course URLs (simplified for now)
        $course->course_urls = null;
        $course->save();

        \Log::info('Course created successfully', ['course_id' => $course->id]);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course->load(['enrollments.user', 'reviews.student', 'teacher', 'category']);
        
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $teachers = User::byRole('instructor')->get();
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
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:200'],
            'video_file' => ['nullable', 'file', 'mimes:mp4,avi,mov,wmv,flv', 'max:102400'], // 100MB max
            'video_url' => ['nullable', 'url'],
            'course_urls' => ['nullable', 'array'],
            'course_urls.*.title' => ['required_with:course_urls.*.url', 'string', 'max:255'],
            'course_urls.*.url' => ['required_with:course_urls.*.title', 'url'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);

        $courseData = $request->all();
        $courseData['slug'] = Str::slug($request->title);
        $courseData['duration_hours'] = $request->duration;

        // Handle thumbnail upload - Store as file path for better performance
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            
            // Generate a unique filename
            $filename = 'course_' . $course->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store in public disk under courses/thumbnails
            $path = $file->storeAs('courses/thumbnails', $filename, 'public');
            
            // Delete old thumbnail if it was a file path (not base64)
            if ($course->thumbnail && strpos($course->thumbnail, 'data:image/') === false) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            
            // Store the path (without 'storage/' prefix - the accessor will handle URL generation)
            $courseData['thumbnail'] = $path;
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            // Delete old video if exists
            if ($course->video_file) {
                Storage::disk('public')->delete($course->video_file);
            }
            $courseData['video_file'] = $request->file('video_file')->store('courses/videos', 'public');
        }

        // Handle course URLs
        if ($request->course_urls) {
            $validUrls = array_filter($request->course_urls, function($url) {
                return !empty($url['title']) && !empty($url['url']);
            });
            $courseData['course_urls'] = array_values($validUrls);
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

        // Delete video file if exists
        if ($course->video_file) {
            Storage::disk('public')->delete($course->video_file);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
