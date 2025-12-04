<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseSectionController extends Controller
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $this->authorize('update', $course);

        $maxOrder = CourseSection::where('course_id', $course->id)->max('order') ?? 0;

        $section = CourseSection::create([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'order' => $maxOrder + 1,
        ]);

        return response()->json([
            'success' => true,
            'section' => $section,
            'message' => 'Section created successfully!',
        ]);
    }

    public function update(Request $request, CourseSection $section)
    {
        $this->authorize('update', $section->course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $section->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully!',
        ]);
    }

    public function destroy(CourseSection $section)
    {
        $this->authorize('delete', $section->course);

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully!',
        ]);
    }

    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:course_sections,id',
            'sections.*.order' => 'required|integer',
        ]);

        foreach ($validated['sections'] as $section) {
            CourseSection::where('id', $section['id'])->update(['order' => $section['order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Sections reordered successfully!',
        ]);
    }
}
