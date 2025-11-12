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
            'total_teachers' => User::role('teacher')->count(),
            'total_students' => User::role('student')->count(),
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

        return view('admin.dashboard', compact('stats', 'recent_enrollments', 'recent_payments'));
    }
}
