<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use App\Http\Requests\StoreCourseCategoryRequest;
use App\Http\Requests\UpdateCourseCategoryRequest;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CourseCategory::withCount('courses')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.course-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.course-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseCategoryRequest $request)
    {
        try {
            CourseCategory::create($request->validated());

            return redirect()
                ->route('admin.course-categories.index')
                ->with('success', 'Course category created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseCategory $courseCategory)
    {
        $courseCategory->load('courses');
        return view('admin.course-categories.show', compact('courseCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course-categories.edit', compact('courseCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseCategoryRequest $request, CourseCategory $courseCategory)
    {
        try {
            $courseCategory->update($request->validated());

            return redirect()
                ->route('admin.course-categories.index')
                ->with('success', 'Course category updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourseCategory $courseCategory)
    {
        try {
            // Check if category has courses
            if ($courseCategory->courses()->count() > 0) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete category with existing courses. Please reassign or delete courses first.');
            }

            $courseCategory->delete();

            return redirect()
                ->route('admin.course-categories.index')
                ->with('success', 'Course category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete category: ' . $e->getMessage());
        }
    }

    /**
     * Toggle category status (active/inactive).
     */
    public function toggleStatus(CourseCategory $courseCategory)
    {
        try {
            $newStatus = $courseCategory->status === 'active' ? 'inactive' : 'active';
            $courseCategory->update(['status' => $newStatus]);

            return redirect()
                ->back()
                ->with('success', 'Category status updated successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }
}
