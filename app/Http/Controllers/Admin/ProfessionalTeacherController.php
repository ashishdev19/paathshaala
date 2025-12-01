<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfessionalTeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = Teacher::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.professional-teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.professional-teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            // 'country_flag' => 'nullable|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            // 'country_flag' => $validated['country_flag'] ?? null,
            'is_active' => $request->has('is_active')
        ];

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('teachers', 'public');
            $data['profile_image'] = $imagePath;
        }

        Teacher::create($data);

        return redirect()->route('admin.professional-teachers.index')
            ->with('success', 'Professional teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $professionalTeacher)
    {
        return view('admin.professional-teachers.show', compact('professionalTeacher'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $professionalTeacher)
    {
        return view('admin.professional-teachers.edit', compact('professionalTeacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $professionalTeacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            // 'country_flag' => 'nullable|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $data = [
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            // 'country_flag' => $validated['country_flag'] ?? null,
            'is_active' => $request->has('is_active')
        ];

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($professionalTeacher->profile_image) {
                Storage::disk('public')->delete($professionalTeacher->profile_image);
            }
            $imagePath = $request->file('profile_image')->store('teachers', 'public');
            $data['profile_image'] = $imagePath;
        }

        $professionalTeacher->update($data);

        return redirect()->route('admin.professional-teachers.index')
            ->with('success', 'Professional teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $professionalTeacher)
    {
        // Delete associated image
        if ($professionalTeacher->profile_image) {
            Storage::disk('public')->delete($professionalTeacher->profile_image);
        }

        $professionalTeacher->delete();

        return redirect()->route('admin.professional-teachers.index')
            ->with('success', 'Professional teacher deleted successfully.');
    }
}
