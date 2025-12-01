# Dashboard Routing Guide

## Overview
This document explains the complete role-based dashboard routing system in Paathshaala.

## Authentication Flow

```
User Login (POST /login)
    ↓
CustomLoginController@login
    ↓
Role Detection (using Spatie Permissions)
    ↓
    ├─→ Admin Role    → redirect to /admin/dashboard
    ├─→ Teacher Role  → redirect to /teacher/dashboard
    └─→ Student Role  → redirect to /student/dashboard
```

## Dashboard Routes

### 1. Admin Dashboard
- **URL**: `/admin/dashboard`
- **Route Name**: `admin.dashboard`
- **Controller**: `App\Http\Controllers\Admin\AdminController@dashboard`
- **Middleware**: `auth`, `role:admin`
- **View**: `resources/views/admin/dashboard.blade.php`

**Statistics Displayed**:
- Total Courses
- Total Enrollments
- Total Teachers
- Total Students
- Total Online Classes
- Total Payments (Sum)
- Pending Payments
- Completed Payments
- Certificates Issued

**Data Shown**:
- Recent Enrollments (Last 5)
- Recent Payments (Last 5)

---

### 2. Teacher Dashboard
- **URL**: `/teacher/dashboard`
- **Route Name**: `teacher.dashboard`
- **Controller**: `App\Http\Controllers\Teacher\TeacherController@dashboard`
- **Middleware**: `auth`, `role:teacher`
- **View**: `resources/views/teacher/dashboard.blade.php`

**Statistics Displayed**:
- Total Courses (Teacher's)
- Total Students (Enrolled in teacher's courses)
- Total Enrollments
- Active Courses
- Pending Courses
- Completed Courses

**Data Shown**:
- Recent Enrollments (Last 5 in teacher's courses)
- Upcoming Classes (Next 5)
- Students Per Course
- Teacher's All Courses

**Quick Actions**:
- Upload Video (Create Online Class)

---

### 3. Student Dashboard
- **URL**: `/student/dashboard`
- **Route Name**: `student.dashboard`
- **Controller**: `App\Http\Controllers\Student\StudentController@dashboard`
- **Middleware**: `auth`, `role:student`
- **View**: `resources/views/student/dashboard.blade.php`

**Statistics Displayed**:
- Total Enrollments
- Active Courses
- Completed Courses
- Certificates Earned
- Total Payments (Sum)
- Average Progress (%)

**Data Shown**:
- All Enrollments with Course Details
- Upcoming Classes (Next 5)
- Recent Certificates (Last 3)
- Recent Payments (Last 5)

**Quick Actions**:
- Browse Courses
- My Courses

---

## Role-Based Access Control

### Middleware Configuration
Located in: `bootstrap/app.php`

```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

### RoleMiddleware Logic
Located in: `app/Http/Middleware/RoleMiddleware.php`

- Checks if user is authenticated
- Validates user has required role using Spatie Permissions
- Returns 403 if access denied
- Redirects to login if not authenticated

---

## Login Controller Implementation

### File: `app/Http/Controllers/Auth/CustomLoginController.php`

```php
public function login(Request $request)
{
    // Validate credentials
    $credentials = $request->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        
        // Role-based redirect
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('student')) {
            return redirect()->route('student.dashboard');
        }
        
        return redirect()->route('dashboard'); // Fallback
    }
    
    return back()->withErrors(['email' => 'Invalid credentials']);
}
```

---

## Route Structure

### Admin Routes (Prefix: `/admin`)
```php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('teachers', AdminTeacherController::class);
    Route::resource('students', StudentController::class);
    Route::resource('courses', AdminCourseController::class);
    Route::resource('offers', OfferController::class);
    // ... more routes
});
```

### Teacher Routes (Prefix: `/teacher`)
```php
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [TeacherController::class, 'courses'])->name('courses');
    Route::get('/students', [TeacherController::class, 'students'])->name('students');
    Route::get('/classes', [TeacherController::class, 'classes'])->name('classes');
    // ... subscription routes
});
```

### Student Routes (Prefix: `/student`)
```php
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::get('/browse-courses', [StudentController::class, 'browseCourses'])->name('courses.browse');
    Route::get('/certificates', [StudentController::class, 'certificates'])->name('certificates');
    // ... more routes
});
```

---

## Directory Structure

### Views
```
resources/views/
├── admin/
│   ├── dashboard.blade.php          ← Admin Dashboard
│   ├── courses/
│   ├── teachers/
│   ├── students/
│   ├── subscription-plans/
│   └── subscriptions/
├── teacher/
│   ├── dashboard.blade.php          ← Teacher Dashboard
│   ├── courses/
│   ├── classes/
│   ├── students/
│   └── subscriptions/
└── student/
    ├── dashboard.blade.php          ← Student Dashboard
    └── courses/
```

### Controllers
```
app/Http/Controllers/
├── Admin/
│   └── AdminController.php          ← Admin Dashboard Logic
├── Teacher/
│   └── TeacherController.php        ← Teacher Dashboard Logic
└── Student/
    └── StudentController.php        ← Student Dashboard Logic
```

---

## Testing Dashboard Access

### 1. Admin Dashboard
```bash
# Login as admin
POST /login
{
    "email": "admin@paathshaala.com",
    "password": "password"
}

# Redirects to: /admin/dashboard
```

### 2. Teacher Dashboard
```bash
# Login as teacher
POST /login
{
    "email": "teacher@paathshaala.com",
    "password": "password"
}

# Redirects to: /teacher/dashboard
```

### 3. Student Dashboard
```bash
# Login as student
POST /login
{
    "email": "student@paathshaala.com",
    "password": "password"
}

# Redirects to: /student/dashboard
```

---

## Security Features

1. **Authentication Required**: All dashboards require user to be logged in
2. **Role-Based Access**: Each dashboard protected by role middleware
3. **CSRF Protection**: All POST requests protected
4. **Session Management**: Automatic session regeneration on login
5. **403 Forbidden**: Users attempting to access unauthorized dashboards get 403 error

---

## Fallback Route

The generic `/dashboard` route (without role prefix) automatically redirects based on user role:

```php
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    } elseif ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    }
    return view('dashboard'); // Fallback view
})->middleware(['auth', 'verified'])->name('dashboard');
```

---

## Common Issues & Solutions

### Issue 1: "Target class [AdminController] does not exist"
**Solution**: Ensure proper import in `routes/web.php`:
```php
use App\Http\Controllers\Admin\AdminController;
```

### Issue 2: 403 Forbidden on dashboard access
**Solution**: Check user has correct role assigned using Spatie Permissions:
```php
$user->assignRole('admin'); // or 'teacher' or 'student'
```

### Issue 3: Infinite redirect loop
**Solution**: Verify middleware is not applied twice and role check is correct.

---

## Database Seeders

### Admin User
```php
// database/seeders/AdminSeeder.php
$admin = User::create([
    'name' => 'Admin',
    'email' => 'admin@paathshaala.com',
    'password' => bcrypt('password'),
]);
$admin->assignRole('admin');
```

### Teacher & Student Users
Similar seeders should exist for teacher and student roles.

---

## Summary

✅ **Admin Dashboard**: Full system overview with all statistics  
✅ **Teacher Dashboard**: Course management, student tracking, class scheduling  
✅ **Student Dashboard**: Learning progress, enrolled courses, certificates  
✅ **Automatic Redirect**: Login automatically routes to correct dashboard  
✅ **Security**: Role-based middleware protects all dashboards  
✅ **Responsive**: All dashboards use Tailwind CSS for mobile responsiveness  

---

**Last Updated**: November 21, 2025  
**Laravel Version**: 12.37.0  
**Authentication**: Custom + Spatie Permissions
