<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseSection;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InstructorCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Allow both 'instructor' and 'teacher' roles for backward compatibility
        $this->middleware(function ($request, $next) {
            $user = $request->user();
            if (!$user || (!$user->isInstructor() && !$user->isAdmin() && !$user->isSuperAdmin())) {
                abort(403, 'You must be an instructor to access this resource.');
            }
            return $next($request);
        });
    }

    // Step 1: Course Basics
    public function createBasics()
    {
        $user = Auth::user();
        
        // Check if user has active subscription
        if (!$user->hasActiveSubscription()) {
            return redirect()->route('instructor.subscription.show')
                ->with('error', 'You need an active subscription to create courses. Please subscribe to a plan first.');
        }
        
        $categories = CourseCategory::active()
            ->orderBy('name')
            ->get();

        return view('instructor.courses.create.basics', compact('categories'));
    }

    public function storeBasics(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:course_categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:50',
            'course_mode' => 'required|in:online,offline,hybrid',
            'duration' => 'nullable|string|max:100',
            'class_start_time' => 'nullable|date_format:H:i',
            'class_end_time' => 'nullable|date_format:H:i|after:class_start_time',
            'batch_start_date' => 'nullable|date',
            'batch_end_date' => 'nullable|date|after_or_equal:batch_start_date',
        ]);

        $course = new Course();
        $course->fill($validated);
        $course->teacher_id = Auth::id();
        $course->status = 'draft';
        $course->price = 0; // Default price, will be updated in pricing step
        $course->slug = Str::slug($validated['title']) . '-' . uniqid();
        
        // Set mode field separately as it's called 'course_mode' in form but 'mode' in database
        $course->mode = $validated['course_mode'];
        
        $course->save();

        session(['course_id' => $course->id]);

        return redirect()->route('instructor.courses.create.media')->with('success', 'Basic details saved!');
    }

    // Step 2: Media Upload
    public function createMedia()
    {
        $courseId = session('course_id');
        $course = Course::findOrFail($courseId);

        return view('instructor.courses.create.media', compact('course'));
    }

    public function storeMedia(Request $request)
    {
        $validated = $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:200',
            'promo_video_url' => 'nullable|url',
            'demo_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'demo_lecture' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:51200',
        ]);

        $courseId = session('course_id');
        $course = Course::findOrFail($courseId);

        // Handle thumbnail upload - Store as file path for better performance
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            
            // Generate a unique filename
            $filename = 'course_' . $course->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store in public disk under courses/thumbnails
            $path = $file->storeAs('courses/thumbnails', $filename, 'public');
            
            // Delete old thumbnail if it was a file path (not base64)
            if ($course->thumbnail && strpos($course->thumbnail, 'data:image/') === false) {
                $oldPath = str_replace('storage/', '', $course->thumbnail);
                \Storage::disk('public')->delete($oldPath);
            }
            
            // Store the path (without 'storage/' prefix - the accessor will handle URL generation)
            $course->thumbnail = $path;
        }

        // Handle promo video URL
        if ($request->filled('promo_video_url')) {
            $course->promo_video_url = $request->promo_video_url;
        }

        // Handle demo PDF
        if ($request->hasFile('demo_pdf')) {
            $path = $request->file('demo_pdf')->store('courses/pdfs', 'public');
            $course->demo_pdf = 'storage/' . $path;
        }

        // Handle demo lecture
        if ($request->hasFile('demo_lecture')) {
            $path = $request->file('demo_lecture')->store('courses/demos', 'public');
            $course->demo_lecture = 'storage/' . $path;
        }

        $course->save();

        return redirect()->route('instructor.courses.create.curriculum')->with('success', 'Media uploaded successfully!');
    }

    // Step 3: Curriculum Builder
    public function createCurriculum()
    {
        $courseId = session('course_id');
        $course = Course::with('sections.lectures')->findOrFail($courseId);

        return view('instructor.courses.create.curriculum', compact('course'));
    }

    // Edit Curriculum for existing course
    public function editCurriculum(Course $course)
    {
        $this->authorize('update', $course);
        $course->load('sections.lectures');
        return view('instructor.courses.curriculum', compact('course'));
    }

    // Step 4: Pricing
    public function createPricing()
    {
        $courseId = session('course_id');
        $course = Course::findOrFail($courseId);

        return view('instructor.courses.create.pricing', compact('course'));
    }

    public function storePricing(Request $request)
    {
        $validated = $request->validate([
            'is_free' => 'boolean',
            'price' => 'required_if:is_free,false|nullable|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'validity_days' => 'nullable|integer|min:1',
            'gst_enabled' => 'boolean',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle checkbox default
        $validated['gst_enabled'] = $request->has('gst_enabled');
        $validated['gst_percentage'] = $validated['gst_percentage'] ?? 18.00;

        $courseId = session('course_id');
        $course = Course::findOrFail($courseId);

        $course->update($validated);
        $course->status = 'published'; // Publish course after pricing
        $course->save();

        session()->forget('course_id');

        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully!');
    }

    // Step 5: SEO Settings
    public function createSeo()
    {
        $courseId = session('course_id');
        $course = Course::findOrFail($courseId);

        return view('instructor.courses.create.seo', compact('course'));
    }

    public function storeSeo(Request $request)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:160',
            'slug' => 'nullable|string|max:255|unique:courses,slug',
        ]);

        $courseId = session('course_id');
        $course = Course::findOrFail($courseId);

        $course->update($validated);

        return redirect()->route('instructor.courses.create.review')->with('success', 'SEO settings saved!');
    }

    // Step 6: Review & Submit
    public function createReview()
    {
        $courseId = session('course_id');
        $course = Course::with('sections.lectures')->findOrFail($courseId);

        return view('instructor.courses.create.review', compact('course'));
    }

    public function submitForReview(Request $request)
    {
        $courseId = session('course_id');
        $course = Course::with('sections.lectures')->findOrFail($courseId);

        // Validate course is complete
        if (!$course->title || !$course->description || !$course->category) {
            return back()->with('error', 'Please complete all required fields!');
        }

        if ($course->sections()->count() === 0) {
            return back()->with('error', 'Please add at least one section with lectures!');
        }

        // Update course status
        $course->status = 'under_review';
        $course->save();

        session()->forget('course_id');

        return redirect()->route('instructor.courses.index')->with('success', 'Course submitted for review!');
    }

    // Main course list
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Check if instructor has active subscription
        $hasSubscription = $user->hasActiveSubscription();
        
        $query = Course::where('teacher_id', Auth::id());

        // Handle Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total' => $courses->total(),
            'active' => Course::where('teacher_id', Auth::id())->where('status', 'published')->count(),
            'students' => 0, // Can be calculated from enrollments
            'revenue' => 0, // Can be calculated from payments
        ];

        return view('instructor.courses.index', compact('courses', 'stats', 'hasSubscription'));
    }

    // View course details
    public function show(Course $course)
    {
        $this->authorize('view', $course);

        // Eager load the category relationship
        $course->load('category');

        return view('instructor.courses.show', compact('course'));
    }

    // Edit course
    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return view('instructor.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:course_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:200',
            'syllabus_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:512000',
            'video_url' => 'nullable|url',
            'price' => 'nullable|numeric|min:0',
            'status' => 'nullable|in:draft,published,archived',
            'gst_enabled' => 'boolean',
            'gst_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle GST checkbox
        $validated['gst_enabled'] = $request->has('gst_enabled');
        $validated['gst_percentage'] = $validated['gst_percentage'] ?? 18.00;

        // Handle thumbnail upload - Store as file path for better performance
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            
            // Generate a unique filename
            $filename = 'course_' . $course->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store in public disk under courses/thumbnails
            $path = $file->storeAs('courses/thumbnails', $filename, 'public');
            
            // Delete old thumbnail if it was a file path (not base64)
            if ($course->thumbnail && strpos($course->thumbnail, 'data:image/') === false) {
                $oldPath = str_replace('storage/', '', $course->thumbnail);
                \Storage::disk('public')->delete($oldPath);
            }
            
            // Store the path (without 'storage/' prefix - the accessor will handle URL generation)
            $validated['thumbnail'] = $path;
        }

        // Handle PDF upload
        if ($request->hasFile('syllabus_pdf')) {
            $path = $request->file('syllabus_pdf')->store('courses/pdfs', 'public');
            $validated['syllabus'] = ['pdf' => $path];
        }

        // Handle video file upload
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('courses/videos', 'public');
            $validated['video_file'] = 'storage/' . $path;
        }

        // Remove file inputs from validated data
        unset($validated['syllabus_pdf']);

        $course->update($validated);

        return redirect()->route('instructor.courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    // Delete course
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}
