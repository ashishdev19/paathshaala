<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get admin-level statistics
        $stats = [
            'professors' => User::byRole('instructor')->count(),
            'students' => User::byRole('student')->count(),
            'courses' => Course::count(),
            'enrollments' => Enrollment::count(),
            'pending_approvals' => Course::where('status', 'pending')->count(),
            'active_courses' => Course::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
