# RBAC (Role-Based Access Control) System Documentation

## Overview
Complete Role-Based Access Control system with 4 roles: Super Admin, Admin, Instructor, and Student.

## Roles

| Role | Slug | Description |
|------|------|-------------|
| Super Admin | `superadmin` | Full system access |
| Admin | `admin` | Platform management |
| Instructor | `instructor` | Course & class management |
| Student | `student` | Course enrollment & access |

## Database Tables

### roles
```
- id
- name (e.g., "Super Admin")
- slug (e.g., "superadmin")
- description
- timestamps
```

### permissions
```
- id
- name (e.g., "Manage Users")
- slug (e.g., "manage-users")
- description
- timestamps
```

### role_permissions (Pivot)
```
- id
- role_id (FK to roles)
- permission_id (FK to permissions)
- timestamps
```

### users (Updated)
```
- id
- name
- email
- password
- role_id (FK to roles) ← NEW FIELD
- timestamps
```

## Models

### Role Model
Location: `app/Models/Role.php`

**Methods:**
- `users()` - Get all users with this role
- `permissions()` - Get all permissions assigned
- `hasPermission($slug)` - Check if role has permission
- `hasAnyPermission(array)` - Check if has any of permissions
- `hasAllPermissions(array)` - Check if has all permissions
- `givePermissionTo($permission)` - Assign permission
- `revokePermissionFrom($permission)` - Remove permission

### Permission Model
Location: `app/Models/Permission.php`

**Methods:**
- `roles()` - Get all roles with this permission

### User Model (Updated)
Location: `app/Models/User.php`

**New Methods:**
- `isSuperAdmin()` - Check if user is super admin
- `isAdmin()` - Check if user is admin
- `isInstructor()` - Check if user is instructor
- `isStudent()` - Check if user is student
- `hasRole($slug)` - Check if user has specific role
- `hasPermission($permission)` - Check if user has permission
- `assignRole($role)` - Assign role to user
- `role()` - Get user's role (relationship)

## Middleware

### RoleMiddleware
Location: `app/Http/Middleware/RoleMiddleware.php`

**Usage in routes:**
```php
// Single role
Route::middleware(['role:superadmin'])->group(function () {
    // Only super admins can access
});

// Multiple roles (user can have any of them)
Route::middleware(['role:admin,superadmin'])->group(function () {
    // Admins and super admins can access
});
```

**Registration in Kernel:**
The middleware is already registered in `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

## User Helper Methods

### Check Role
```php
$user = auth()->user();

// Direct checks
$user->isSuperAdmin();    // true or false
$user->isAdmin();         // true or false
$user->isInstructor();    // true or false
$user->isStudent();       // true or false

// Generic check
$user->hasRole('student');
$user->hasRole(['student', 'instructor']); // Check multiple roles

// Check permission
$user->hasPermission('manage-users');
```

### Assign Role
```php
$user = User::find(1);

// Assign by slug
$user->assignRole('instructor');

// Assign by Role object
$role = Role::where('slug', 'admin')->first();
$user->assignRole($role);
```

### Get Role Info
```php
$user = auth()->user();

// Get role object
$user->role;                    // Role instance
$user->role->name;              // "Student"
$user->role->slug;              // "student"
$user->role->description;       // Role description
$user->role->permissions;       // Permissions collection
```

## In Blade Templates

### Check Role
```blade
@if (auth()->user()->isSuperAdmin())
    <!-- Super Admin Content -->
@endif

@if (auth()->user()->isAdmin())
    <!-- Admin Content -->
@endif

@if (auth()->user()->isInstructor())
    <!-- Instructor Content -->
@endif

@if (auth()->user()->isStudent())
    <!-- Student Content -->
@endif

<!-- Check multiple roles -->
@if (auth()->user()->hasRole(['admin', 'superadmin']))
    <!-- Admin or Super Admin Content -->
@endif
```

### Check Permission
```blade
@if (auth()->user()->hasPermission('manage-users'))
    <a href="/admin/users">Manage Users</a>
@endif
```

### Display Role Badge
```blade
<span class="role-badge {{ auth()->user()->role->slug }}">
    {{ auth()->user()->role->name }}
</span>
```

## Route Protection Examples

### Basic Route Protection
```php
// Only super admins
Route::middleware(['role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])
        ->name('superadmin.dashboard');
});

// Only admins (or super admins with middleware check)
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');
});

// Only instructors
Route::middleware(['role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'dashboard'])
        ->name('instructor.dashboard');
});

// Only students
Route::middleware(['role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])
        ->name('student.dashboard');
});
```

### Mixed Protection
```php
// Instructors and Super Admins
Route::middleware(['role:instructor,superadmin'])->group(function () {
    Route::get('/courses/create', [CourseController::class, 'create']);
});

// Multiple middleware
Route::middleware(['auth', 'role:admin'])
    ->group(function () {
        // Requires auth AND admin role
    });
```

## Login Redirection

### In AuthenticatedSessionController
Location: `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

```php
public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();

    // Redirect based on role
    if ($user->isSuperAdmin()) {
        return redirect()->intended('/superadmin/dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->intended('/admin/dashboard');
    } elseif ($user->isInstructor()) {
        return redirect()->intended('/instructor/dashboard');
    } else {
        // Default to student dashboard
        return redirect()->intended('/student/dashboard');
    }
}
```

### Alternative: Using Role Slug
```php
public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $redirects = [
        'superadmin' => '/superadmin/dashboard',
        'admin'      => '/admin/dashboard',
        'instructor' => '/instructor/dashboard',
        'student'    => '/student/dashboard',
    ];

    $role = auth()->user()->role?->slug ?? 'student';
    return redirect()->intended($redirects[$role] ?? '/');
}
```

## Seeder Usage

### Run Role Seeder
```bash
php artisan db:seed --class=RoleSeeder
```

### What it Creates
- 4 roles (superadmin, admin, instructor, student)
- 25+ permissions
- Test users for each role
  - `superadmin@example.com` (password)
  - `admin@example.com` (password)
  - `instructor@example.com` (password)
  - `student@example.com` (password)

## Complete Route Example

```php
// routes/web.php

Route::middleware(['auth'])->group(function () {

    // Super Admin Routes
    Route::middleware(['role:superadmin'])->prefix('superadmin')->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])
            ->name('superadmin.dashboard');
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('admin.dashboard');
        Route::resource('courses', AdminCourseController::class);
        Route::resource('instructors', InstructorController::class);
        Route::resource('students', StudentController::class);
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

    // Instructor Routes
    Route::middleware(['role:instructor'])->prefix('instructor')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'dashboard'])
            ->name('instructor.dashboard');
        Route::resource('courses', InstructorCourseController::class);
        Route::resource('live-classes', LiveClassController::class);
        Route::get('/enrollments', [EnrollmentController::class, 'index'])
            ->name('enrollments.index');
        Route::get('/wallet', [WalletController::class, 'index'])
            ->name('wallet.index');
    });

    // Student Routes
    Route::middleware(['role:student'])->prefix('student')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])
            ->name('student.dashboard');
        Route::get('/courses', [EnrollmentController::class, 'myCourses'])
            ->name('my-courses');
        Route::post('/enroll/{course}', [EnrollmentController::class, 'enroll'])
            ->name('enroll');
        Route::get('/certificates', [CertificateController::class, 'index'])
            ->name('certificates.index');
    });

});
```

## Permission List

### Super Admin Permissions
- view-dashboard
- manage-users
- manage-roles
- manage-permissions
- manage-courses
- manage-payments
- manage-settings
- view-analytics
- manage-admins

### Admin Permissions
- view-admin-dashboard
- manage-content
- manage-instructors
- manage-students
- manage-payments
- view-reports

### Instructor Permissions
- create-courses
- edit-own-courses
- delete-own-courses
- manage-live-classes
- view-enrollments
- access-wallet

### Student Permissions
- view-courses
- enroll-courses
- access-content
- submit-reviews
- view-certificates

## File Structure

```
app/
├── Http/
│   └── Middleware/
│       └── RoleMiddleware.php
├── Models/
│   ├── User.php (updated)
│   ├── Role.php (new)
│   └── Permission.php (new)
└── ...

database/
├── migrations/
│   ├── 2025_11_28_000001_create_roles_table.php
│   ├── 2025_11_28_000002_create_permissions_table.php
│   ├── 2025_11_28_000003_create_role_permissions_table.php
│   └── 2025_11_28_000004_add_role_id_to_users_table.php
└── seeders/
    └── RoleSeeder.php (updated)
```

## Common Patterns

### Check Permission in Controller
```php
public function delete($id)
{
    $course = Course::findOrFail($id);
    
    if (!auth()->user()->hasPermission('delete-own-courses')) {
        abort(403, 'You do not have permission to delete courses');
    }
    
    $course->delete();
    return redirect()->back()->with('success', 'Course deleted');
}
```

### Conditional Links in Blade
```blade
@auth
    @if (auth()->user()->isSuperAdmin() || auth()->user()->isAdmin())
        <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
    @elseif (auth()->user()->isInstructor())
        <a href="{{ route('instructor.dashboard') }}">Instructor Dashboard</a>
    @else
        <a href="{{ route('student.dashboard') }}">My Dashboard</a>
    @endif
@endauth
```

### Scope Queries by Role
```php
// Get courses by instructor
$instructorCourses = Course::where('teacher_id', auth()->id())->get();

// Get only published courses for students
$publishedCourses = auth()->user()->role?->slug === 'student'
    ? Course::where('status', 'published')->get()
    : Course::all();
```

## Notes

- All passwords default to `password` for test users
- Super Admin has access to everything
- Roles are assigned via `role_id` foreign key
- Permissions are optional and for future expansion
- Middleware checks role slug, not name
- Always check role in sensitive operations

## Next Steps

1. Run migrations: `php artisan migrate`
2. Run seeder: `php artisan db:seed --class=RoleSeeder`
3. Update your controllers to use role checking
4. Protect routes with middleware
5. Add permission checks where needed
