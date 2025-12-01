<?php

// EXAMPLE CONTROLLER IMPLEMENTATIONS
// Copy these patterns to your actual controllers

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

// ============================================
// SUPER ADMIN CONTROLLER EXAMPLE
// ============================================

class SuperAdminController extends Controller
{
    public function __construct()
    {
        // Ensure only super admins can access
        $this->middleware(['auth', 'role:superadmin']);
    }

    public function dashboard()
    {
        // Super admin dashboard with all stats
        $totalUsers = User::count();
        $totalAdmins = User::whereHas('role', fn($q) => $q->where('slug', 'admin'))->count();
        $totalInstructors = User::whereHas('role', fn($q) => $q->where('slug', 'instructor'))->count();
        $totalStudents = User::whereHas('role', fn($q) => $q->where('slug', 'student'))->count();

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalInstructors',
            'totalStudents'
        ));
    }

    public function manageUsers()
    {
        // Only super admin can manage users
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $users = User::with('role')->paginate(15);
        return view('superadmin.users.index', compact('users'));
    }

    public function assignRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validated);

        return back()->with('success', 'Role assigned successfully');
    }
}

// ============================================
// ADMIN CONTROLLER EXAMPLE
// ============================================

class AdminController extends Controller
{
    public function __construct()
    {
        // Admins and super admins can access
        $this->middleware(['auth', 'role:admin,superadmin']);
    }

    public function dashboard()
    {
        // Admin dashboard
        $totalCourses = \App\Models\Course::count();
        $totalEnrollments = \App\Models\Enrollment::count();
        $totalRevenue = \App\Models\Payment::where('status', 'completed')->sum('amount');

        return view('admin.dashboard', compact(
            'totalCourses',
            'totalEnrollments',
            'totalRevenue'
        ));
    }

    public function manageCourses()
    {
        // Only admins or super admins
        $courses = \App\Models\Course::paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    public function approveCourse($courseId)
    {
        // Check permission
        if (!auth()->user()->hasPermission('manage-courses')) {
            abort(403, 'You do not have permission to manage courses');
        }

        $course = \App\Models\Course::findOrFail($courseId);
        $course->update(['status' => 'published']);

        return back()->with('success', 'Course approved');
    }
}

// ============================================
// INSTRUCTOR CONTROLLER EXAMPLE
// ============================================

class InstructorController extends Controller
{
    public function __construct()
    {
        // Instructors only (but super admin can override)
        $this->middleware(['auth', 'role:instructor']);
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Only show own data
        $ownCourses = $user->teacherCourses()->count();
        $totalEnrollments = \App\Models\Enrollment::whereIn(
            'course_id',
            $user->teacherCourses()->pluck('id')
        )->count();
        $totalEarnings = $user->wallet?->balance ?? 0;

        return view('instructor.dashboard', compact(
            'ownCourses',
            'totalEnrollments',
            'totalEarnings'
        ));
    }

    public function createCourse()
    {
        // Check permission
        if (!auth()->user()->hasPermission('create-courses')) {
            abort(403, 'You do not have permission to create courses');
        }

        return view('instructor.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
        ]);

        $course = auth()->user()->teacherCourses()->create($validated);

        return redirect()->route('instructor.courses.show', $course)
            ->with('success', 'Course created successfully');
    }

    public function deleteCourse($courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);

        // Authorization: Can only delete own courses
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You can only delete your own courses');
        }

        // Permission check
        if (!auth()->user()->hasPermission('delete-own-courses')) {
            abort(403, 'You do not have permission to delete courses');
        }

        $course->delete();

        return back()->with('success', 'Course deleted');
    }
}

// ============================================
// STUDENT CONTROLLER EXAMPLE
// ============================================

class StudentController extends Controller
{
    public function __construct()
    {
        // Students only
        $this->middleware(['auth', 'role:student']);
    }

    public function dashboard()
    {
        $user = auth()->user();

        // Only show own data
        $enrolledCourses = $user->enrollments()->count();
        $completedCourses = $user->enrollments()
            ->where('progress', 100)
            ->count();
        $certificates = $user->certificates()->count();

        return view('student.dashboard', compact(
            'enrolledCourses',
            'completedCourses',
            'certificates'
        ));
    }

    public function enrollCourse(Request $request, $courseId)
    {
        // Check permission
        if (!auth()->user()->hasPermission('enroll-courses')) {
            abort(403, 'You do not have permission to enroll in courses');
        }

        $course = \App\Models\Course::findOrFail($courseId);

        // Check if already enrolled
        if (auth()->user()->enrollments()->where('course_id', $courseId)->exists()) {
            return back()->with('error', 'Already enrolled in this course');
        }

        // Create enrollment
        auth()->user()->enrollments()->create([
            'course_id' => $courseId,
            'enrollment_date' => now(),
        ]);

        return back()->with('success', 'Enrolled in course successfully');
    }

    public function viewCourse($courseId)
    {
        $course = \App\Models\Course::findOrFail($courseId);

        // Check enrollment
        $enrollment = auth()->user()->enrollments()
            ->where('course_id', $courseId)
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        return view('student.courses.show', compact('course', 'enrollment'));
    }
}

// ============================================
// AUTHORIZATION PATTERNS IN ROUTES
// ============================================

// routes/web.php

Route::middleware(['auth'])->group(function () {

    // Super Admin Routes
    Route::middleware(['role:superadmin'])->prefix('superadmin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])
            ->name('superadmin.dashboard');
        Route::get('/users', [SuperAdminController::class, 'manageUsers'])
            ->name('superadmin.users.index');
        Route::post('/users/{user}/assign-role', [SuperAdminController::class, 'assignRole'])
            ->name('superadmin.users.assign-role');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
        Route::get('/courses', [AdminController::class, 'manageCourses'])
            ->name('admin.courses.index');
        Route::post('/courses/{course}/approve', [AdminController::class, 'approveCourse'])
            ->name('admin.courses.approve');
    });

    // Instructor Routes
    Route::middleware(['role:instructor'])->prefix('instructor')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'dashboard'])
            ->name('instructor.dashboard');
        Route::get('/courses/create', [InstructorController::class, 'createCourse'])
            ->name('instructor.courses.create');
        Route::post('/courses', [InstructorController::class, 'storeCourse'])
            ->name('instructor.courses.store');
        Route::delete('/courses/{course}', [InstructorController::class, 'deleteCourse'])
            ->name('instructor.courses.destroy');
    });

    // Student Routes
    Route::middleware(['role:student'])->prefix('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])
            ->name('student.dashboard');
        Route::post('/courses/{course}/enroll', [StudentController::class, 'enrollCourse'])
            ->name('student.courses.enroll');
        Route::get('/courses/{course}', [StudentController::class, 'viewCourse'])
            ->name('student.courses.show');
    });

});

// ============================================
// PERMISSION CHECKING IN BLADE
// ============================================

/*
<!-- In blade templates -->

<!-- Check role -->
@if (auth()->user()->isSuperAdmin())
    <a href="{{ route('superadmin.dashboard') }}">Super Admin</a>
@endif

@if (auth()->user()->isAdmin())
    <a href="{{ route('admin.dashboard') }}">Admin</a>
@endif

@if (auth()->user()->isInstructor())
    <a href="{{ route('instructor.dashboard') }}">My Courses</a>
@endif

@if (auth()->user()->isStudent())
    <a href="{{ route('student.dashboard') }}">Dashboard</a>
@endif

<!-- Check permission -->
@if (auth()->user()->hasPermission('manage-users'))
    <a href="/superadmin/users">Manage Users</a>
@endif

@if (auth()->user()->hasPermission('create-courses'))
    <a href="{{ route('instructor.courses.create') }}">Create Course</a>
@endif

<!-- Show role badge -->
<span class="badge badge-{{ auth()->user()->role->slug }}">
    {{ auth()->user()->role->name }}
</span>
*/

// ============================================
// AUTHORIZATION GATE EXAMPLES
// ============================================

/*
// app/Providers/AuthServiceProvider.php

use Illuminate\Support\Facades\Gate;

public function boot(): void
{
    // Define gates based on roles
    Gate::define('manage-users', function ($user) {
        return $user->isSuperAdmin() || $user->isAdmin();
    });

    Gate::define('edit-course', function ($user, $course) {
        // Only instructor who created course or super admin
        return $user->isSuperAdmin() || $user->id === $course->teacher_id;
    });

    Gate::define('view-reports', function ($user) {
        return $user->isSuperAdmin() || $user->isAdmin();
    });
}

// Usage in controller:
if (Gate::denies('edit-course', $course)) {
    abort(403);
}

// Or use @can in blade:
@can('edit-course', $course)
    <a href="{{ route('courses.edit', $course) }}">Edit</a>
@endcan
*/

?>
