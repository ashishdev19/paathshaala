<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class SuperAdminDashboardController extends Controller
{
    /**
     * Display the super admin dashboard
     */
    public function index()
    {
        // Get system-wide statistics
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::byRole('admin')->count(),
            'total_professors' => User::byRole('instructor')->count(),
            'total_students' => User::byRole('student')->count(),
            'total_courses' => Course::count(),
            'total_enrollments' => Enrollment::count(),
            'active_courses' => Course::where('status', 'active')->count(),
        ];

        // Get recent activities
        $recent_users = User::latest()->take(5)->get();
        $recent_enrollments = Enrollment::with(['student', 'course'])->latest()->take(5)->get();

        return view('superadmin.dashboard', compact('stats', 'recent_users', 'recent_enrollments'));
    }

    /**
     * System settings
     */
    public function settings()
    {
        return view('superadmin.settings');
    }

    /**
     * System logs
     */
    public function logs()
    {
        return view('superadmin.logs');
    }
}
