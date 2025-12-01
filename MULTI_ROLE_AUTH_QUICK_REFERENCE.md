# Multi-Role Authentication - Quick Reference Guide

## 📚 Quick Start

### Test Logins
```
Email: superadmin@example.com  → /superadmin/dashboard
Email: admin@example.com       → /admin/dashboard
Email: instructor@example.com  → /professor/dashboard
Email: student@example.com     → /student/dashboard
Password: password (all users)
```

---

## 🔍 How to Check User Roles

```php
$user = Auth::user();

// Check specific role
if ($user->isSuperAdmin()) { }
if ($user->isAdmin()) { }
if ($user->isInstructor()) { }
if ($user->isStudent()) { }

// Check by role slug
if ($user->hasRole('superadmin')) { }
if ($user->hasRole('admin')) { }
if ($user->hasRole('instructor')) { }
if ($user->hasRole('student')) { }

// Check multiple roles
if ($user->hasRole(['admin', 'superadmin'])) { }

// Check permission
if ($user->hasPermission('create_course')) { }
```

---

## 🛡️ How to Protect Routes

### Using Middleware Aliases (Recommended)
```php
// Super Admin only
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/manage-system', ...);
});

// Admin and Super Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/manage-users', ...);
});

// Professor (Instructor), Admin, and Super Admin
Route::middleware(['auth', 'professor'])->group(function () {
    Route::get('/my-courses', ...);
});

// All authenticated users
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/my-profile', ...);
});
```

### Using Role Middleware (Alternative)
```php
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    // Only superadmin can access
});

Route::middleware(['auth', 'role:admin,superadmin'])->group(function () {
    // Admin or superadmin can access
});
```

---

## 📊 Dashboard Routes

| Role | URL | Controller Method |
|------|-----|------------------|
| Super Admin | `/superadmin/dashboard` | `SuperAdminDashboardController@index` |
| Admin | `/admin/dashboard` | `AdminDashboardController@index` |
| Professor | `/professor/dashboard` | `ProfessorDashboardController@index` |
| Student | `/student/dashboard` | `StudentDashboardController@index` |

---

## 🚀 Common Tasks

### Assign Role to User
```php
$user = User::find(1);
$user->assignRole('admin');
// or
$user->update(['role_id' => 2]); // 2 = admin role
```

### Get Users by Role
```php
// Using query scope
$admins = User::byRole('admin')->get();
$instructors = User::byRole('instructor')->get();
$students = User::byRole('student')->get();

// Using relationship
$adminRole = Role::where('slug', 'admin')->first();
$admins = $adminRole->users()->get();
```

### Check if User Can Perform Action
```php
// In Controller
if (!auth()->user()->isSuperAdmin() && !auth()->user()->isAdmin()) {
    abort(403, 'Unauthorized');
}

// Or using middleware on route
Route::post('/delete-user', [UserController::class, 'destroy'])
    ->middleware('admin'); // Only admin+ can access

// Or using Gate/Policy
if (!auth()->user()->can('delete', $user)) {
    abort(403);
}
```

---

## 🔐 File Locations

### Middleware
```
app/Http/Middleware/
├── SuperAdminMiddleware.php
├── AdminMiddleware.php
├── ProfessorMiddleware.php
└── StudentMiddleware.php
```

### Controllers
```
app/Http/Controllers/
├── SuperAdmin/SuperAdminDashboardController.php
├── Admin/AdminDashboardController.php
├── Professor/ProfessorDashboardController.php
└── Student/StudentDashboardController.php
```

### Views
```
resources/views/
├── superadmin/dashboard.blade.php
├── admin/dashboard.blade.php
├── professor/dashboard.blade.php
└── student/dashboard.blade.php
```

### Models & Database
```
app/Models/
├── User.php (has role_id, RBAC methods)
├── Role.php (4 roles: superadmin, admin, instructor, student)
└── Permission.php (25+ permissions)

database/migrations/
├── create_roles_table.php
├── create_permissions_table.php
├── create_role_permissions_table.php
└── add_role_id_to_users_table.php
```

---

## 📋 Role Definitions

### Super Admin
- Full system access
- Can manage users, roles, permissions
- Can view system logs and settings
- Can access all other role routes
- **Cannot be restricted** - has override access

### Admin
- Platform management
- Can manage professors, students, courses
- Can manage subscriptions and payments
- Can view analytics and reports
- Can manage wallet/finance

### Professor (Instructor)
- Course management
- Can create and manage own courses
- Can manage student enrollments
- Can view student progress
- Can create course materials

### Student
- Learning access
- Can view enrolled courses
- Can view course materials
- Can track own progress
- Can explore available courses

---

## 🔗 Middleware Alias Registration

Location: `bootstrap/app.php`

```php
$middleware->alias([
    'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
    'professor' => \App\Http\Middleware\ProfessorMiddleware::class,
    'student' => \App\Http\Middleware\StudentMiddleware::class,
]);
```

---

## 🧪 Testing Authentication

### Run Test Script
```bash
php test_multi_role_auth.php
```

This verifies:
- Middleware files exist and registered
- Controller files exist
- View files exist
- User model RBAC methods
- Test users exist
- LoginController redirects work
- Middleware aliases configured

### Manual Browser Testing
1. Go to `http://localhost:8000/login`
2. Login with different test accounts
3. Verify you're redirected to correct dashboard
4. Try accessing other role's routes (should get 403)

---

## 🐛 Troubleshooting

### Issue: Middleware not found
**Solution**: Make sure middleware alias is registered in `bootstrap/app.php`

### Issue: Route not found
**Solution**: Run `php artisan route:cache` and `php artisan cache:clear`

### Issue: View not found
**Solution**: Check folder structure matches role (superadmin/, admin/, etc.)

### Issue: Wrong redirect on login
**Solution**: Check `CustomLoginController` has correct route names

### Issue: 403 error on dashboard
**Solution**: Verify middleware is checking the correct role method

---

## 💡 Best Practices

1. **Always use middleware** to protect admin routes
2. **Use query scopes** (`byRole()`) instead of manual filtering
3. **Use helper methods** (`isSuperAdmin()`) instead of `hasRole()`
4. **Separate controllers** by role for better organization
5. **Use named routes** (`route('admin.dashboard')`) in redirects
6. **Test different roles** after making changes
7. **Log important actions** (especially admin actions)
8. **Use policies** for model-level authorization

---

## 🔄 Login Flow Diagram

```
User Login
    ↓
CustomLoginController::login()
    ↓
Auth::attempt() - Validate credentials
    ↓
If Success → Get authenticated user
    ↓
Check user role using helper methods:
├─ $user->isSuperAdmin() → /superadmin/dashboard
├─ $user->isAdmin() → /admin/dashboard
├─ $user->isInstructor() → /professor/dashboard
└─ $user->isStudent() → /student/dashboard
    ↓
Route Middleware Check:
├─ 'superadmin' middleware checks isSuperAdmin()
├─ 'admin' middleware checks isAdmin() OR isSuperAdmin()
├─ 'professor' middleware checks isInstructor() OR isAdmin() OR isSuperAdmin()
└─ 'student' middleware allows all authenticated users
    ↓
Display Role-Specific Dashboard
```

---

## 📞 Common Errors & Fixes

### Error: "Non-static method cannot be called statically"
```php
// ❌ Wrong
$users = User::role('admin')->get();

// ✅ Correct
$users = User::byRole('admin')->get();
```

### Error: "Method does not exist" (hasRole vs isSuperAdmin)
```php
// ❌ Old
if ($user->hasRole('admin')) { }

// ✅ New
if ($user->isAdmin()) { }
```

### Error: View [dashboard] not found
```php
// ❌ Wrong - generic dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

// ✅ Correct - role-specific dashboards
Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index'])->middleware('auth', 'superadmin');
```

---

## 🎯 What's Different from Before

| Before | After |
|--------|-------|
| All users → /dashboard | Each role → /role/dashboard |
| Used Spatie permissions | Custom RBAC with roles table |
| Generic login redirect | Role-specific redirects |
| Role middleware only | Hierarchy-aware middleware |
| Single dashboard view | Role-specific dashboard views |

---

## 📞 Support & Questions

For more information, see:
- `MULTI_ROLE_AUTH_COMPLETE.md` - Full implementation guide
- `RBAC_COMPLETE_GUIDE.md` - Complete RBAC documentation
- `ARCHITECTURE_GUIDE.md` - System architecture

---

**Last Updated**: 2024
**System**: Laravel 11 with Multi-Role Authentication
**Roles**: 4 (SuperAdmin, Admin, Professor/Instructor, Student)
**Status**: ✅ Production Ready
