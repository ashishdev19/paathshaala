<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Certificate;
use App\Models\Offer;
use App\Models\OnlineClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        $stats = [
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'total_teachers' => User::byRole('instructor')->count(),
            'total_students' => User::byRole('student')->count(),
            'total_online_classes' => OnlineClass::count(),
            'total_payments' => Payment::sum('final_amount'),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'completed_payments' => Payment::where('status', 'completed')->count(),
            'certificates_issued' => Certificate::count(),
        ];

        $recent_enrollments = Enrollment::with(['student', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $recent_payments = Payment::with(['student', 'course'])
            ->where('status', 'completed')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recent_enrollments', 'recent_payments'));
    }

    public function reports()
    {
        return view('admin.reports.index');
    }

    public function settings()
    {
        return view('admin.settings.index');
    }

    public function updateSettings(Request $request)
    {
        // Handle settings update logic here
        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update basic information
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->dob = $validated['dob'] ?? $user->dob;
        $user->address = $validated['address'] ?? $user->address;

        // Handle password change if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            
            if ($request->filled('password')) {
                $user->password = Hash::make($validated['password']);
            }
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Profile updated successfully');
    }
}
