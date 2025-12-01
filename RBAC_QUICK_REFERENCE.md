# RBAC QUICK REFERENCE

## 🚀 Setup
```bash
# 1. Run migrations
php artisan migrate

# 2. Run seeder
php artisan db:seed --class=RoleSeeder

# 3. Test login with:
# superadmin@example.com / password
# admin@example.com / password
# instructor@example.com / password
# student@example.com / password
```

## 📋 Database Structure
```
users table → role_id → roles table
                        ↓
                   role_permissions
                        ↓
                   permissions table
```

## 🎯 Check User Role (In Controller)
```php
$user = auth()->user();

if ($user->isSuperAdmin()) { }      // Super Admin
if ($user->isAdmin()) { }           // Admin
if ($user->isInstructor()) { }      // Instructor
if ($user->isStudent()) { }         // Student
if ($user->hasRole('student')) { }  // Generic check
if ($user->hasPermission('manage-users')) { }  // Check permission
```

## 🛡️ Protect Routes
```php
// Protect single role
Route::middleware(['role:superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', ...);
});

// Protect multiple roles
Route::middleware(['role:admin,superadmin'])->group(function () {
    Route::get('/admin/dashboard', ...);
});
```

## 🎨 Show in Blade
```blade
@if (auth()->user()->isSuperAdmin())
    <div>Super Admin Only</div>
@endif

@if (auth()->user()->isInstructor())
    <div>Instructor Only</div>
@endif

@unless (auth()->user()->isStudent())
    <div>Not a student</div>
@endunless
```

## 📌 Assign Role to User
```php
$user = User::find(1);
$user->assignRole('instructor');  // By slug
$user->assignRole($role);         // By role object
```

## 🔑 Available Roles
| Slug | Name | Access |
|------|------|--------|
| `superadmin` | Super Admin | Everything |
| `admin` | Admin | Platform management |
| `instructor` | Instructor | Courses & classes |
| `student` | Student | Course enrollment |

## 📂 Files Modified/Created
```
✅ app/Models/Role.php (NEW)
✅ app/Models/Permission.php (NEW)
✅ app/Models/User.php (UPDATED - added role relation + helpers)
✅ app/Http/Middleware/RoleMiddleware.php (EXISTS - already correct)
✅ database/migrations/2025_11_28_*.php (NEW - 4 migrations)
✅ database/seeders/RoleSeeder.php (UPDATED)
✅ RBAC_DOCUMENTATION.md (NEW)
```

## 🚦 Login Redirect Logic
Update `app/Http/Controllers/Auth/AuthenticatedSessionController.php`:

```php
public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = auth()->user();
    
    if ($user->isSuperAdmin()) {
        return redirect()->intended('/superadmin/dashboard');
    } elseif ($user->isAdmin()) {
        return redirect()->intended('/admin/dashboard');
    } elseif ($user->isInstructor()) {
        return redirect()->intended('/instructor/dashboard');
    } else {
        return redirect()->intended('/dashboard');
    }
}
```

## 💡 Common Use Cases

### Check if user can delete a course
```php
if (!auth()->user()->hasPermission('delete-own-courses')) {
    abort(403, 'Not allowed');
}
```

### Protect admin routes
```php
Route::middleware(['auth', 'role:admin,superadmin'])
    ->get('/admin/users', [UserController::class, 'index']);
```

### Scope by role in query
```php
$courses = Course::when(
    !auth()->user()->isAdmin(),
    fn($q) => $q->where('status', 'published')
)->get();
```

### Show conditional navigation
```blade
<nav>
    @if (auth()->user()?->isAdmin())
        <a href="/admin">Admin</a>
    @endif
    
    @if (auth()->user()?->isInstructor())
        <a href="/instructor">Courses</a>
    @endif
    
    @if (auth()->user()?->isStudent())
        <a href="/student">Dashboard</a>
    @endif
</nav>
```

## ❌ Troubleshooting

### Role not working?
```bash
# Clear cache
php artisan cache:clear

# Make sure user has role_id set
php artisan tinker
# $user = User::find(1);
# $user->role_id = 1; // Superadmin role id
# $user->save();
```

### Seeder fails?
```bash
# Reset and run fresh
php artisan migrate:refresh
php artisan db:seed --class=RoleSeeder
```

### Middleware not protecting?
- Ensure middleware is registered in `app/Http/Kernel.php`
- Check route syntax: `Route::middleware(['role:admin'])`
- Verify user is authenticated: `Route::middleware(['auth', 'role:admin'])`

## 📊 Role Hierarchy
```
Super Admin
├── Full system access
├── Can create other admins
└── Can manage everything

Admin
├── Manage users, courses, payments
├── Cannot manage system settings
└── Cannot manage other admins

Instructor
├── Create and manage own courses
├── Manage own live classes
├── Access wallet
└── Cannot manage other instructors

Student
├── View courses
├── Enroll in courses
├── Submit reviews
└── Cannot create courses
```

## 🎓 Testing Roles
```php
// In tinker or controller
$user = User::find(1);
$user->isSuperAdmin();     // Check role
$user->role->permissions;  // Check permissions
$user->hasPermission('manage-users');  // Specific permission
```

---

**Total Files Created/Modified: 10**
- 4 migrations
- 2 new models (Role, Permission)
- 1 updated model (User)
- 1 existing middleware (RoleMiddleware - already correct)
- 1 updated seeder
- 1 documentation file
- This quick reference

**Ready to use! 🎉**
