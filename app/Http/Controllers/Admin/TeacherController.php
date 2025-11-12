<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $teachers = User::role('teacher')->with('teacherCourses')->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $teacher = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'email_verified_at' => now(),
        ]);

        $teacher->assignRole('teacher');

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher created successfully.');
    }

    public function show(User $teacher)
    {
        $teacher->load(['teacherCourses.enrollments', 'teacherCourses.reviews']);
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(User $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, User $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($teacher->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $teacher->update($updateData);

        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher updated successfully.');
    }

    public function destroy(User $teacher)
    {
        $teacher->delete();
        return redirect()->route('admin.teachers.index')
            ->with('success', 'Teacher deleted successfully.');
    }
}
