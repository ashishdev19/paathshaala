# 🔐 Spatie Permission System - Refactoring Complete

## Overview
This document describes the complete refactoring of the role/permission system to use **Spatie Laravel Permission** package exclusively.

---

## ✅ Changes Made

### 1. Migration Created
**File:** `database/migrations/2026_01_09_100000_remove_user_type_and_cleanup_custom_role_tables.php`

This migration:
- ❌ Removes `user_type` column from `users` table
- ❌ Drops `admin_role_permission` pivot table
- ❌ Drops `admin_accounts` table
- ❌ Drops `admin_permissions` table
- ❌ Drops `admin_roles` table

### 2. Models Removed
The following custom models have been **deleted** (Spatie models are used instead):
- ❌ `app/Models/Role.php`
- ❌ `app/Models/Permission.php`
- ❌ `app/Models/AdminRole.php`
- ❌ `app/Models/AdminPermission.php`
- ❌ `app/Models/AdminAccount.php`

### 3. User Model Updated
**File:** `app/Models/User.php`
- ✅ Already has `use HasRoles` trait
- ✅ Removed `user_type` from `$fillable`
- ✅ Helper methods use Spatie's `hasRole()`:
  - `isSuperAdmin()` → `$this->hasRole('superadmin')`
  - `isAdmin()` → `$this->hasRole('admin')`
  - `isInstructor()` → `$this->hasRole('instructor')`
  - `isStudent()` → `$this->hasRole('student')`

### 4. Controllers Updated
**AdminRoleController.php** - Now uses `Spatie\Permission\Models\Role`
**AdminPermissionController.php** - Now uses `Spatie\Permission\Models\Permission`
**AdminAccountController.php** - Now uses `User` model with admin/superadmin roles
**CustomRegisterController.php** - Uses `role` field instead of `user_type`

### 5. Middleware Updated
**SuperAdminMiddleware.php** - Fixed to use `hasRole()` instead of loading custom role relationship

### 6. Blade Files Updated
**register.blade.php** - Changed `user_type` field to `role`
**admin/roles/index.blade.php** - Updated for Spatie Role fields

### 7. Routes Updated
**routes/web.php** - Updated model binding for User accounts

### 8. Bootstrap Updated
**bootstrap/app.php** - Added Spatie middleware aliases:
- `spatie.role`
- `spatie.permission`
- `spatie.role_or_permission`

---

## 📋 Spatie Tables (Keep These)

| Table | Purpose |
|-------|---------|
| `roles` | Stores role definitions (superadmin, admin, instructor, student) |
| `permissions` | Stores permission definitions |
| `model_has_roles` | Links users to roles |
| `model_has_permissions` | Links users to direct permissions |
| `role_has_permissions` | Links roles to permissions |

---

## 🔧 Authorization Methods to Use

### Role Checking
```php
// Check single role
$user->hasRole('admin');

// Check any of multiple roles
$user->hasAnyRole(['admin', 'superadmin']);

// Check all roles
$user->hasAllRoles(['admin', 'editor']);
```

### Permission Checking
```php
// Check permission
$user->can('edit-posts');
$user->hasPermissionTo('edit-posts');

// Check any permission
$user->hasAnyPermission(['edit-posts', 'delete-posts']);
```

### Blade Directives
```blade
@role('admin')
    <!-- Admin content -->
@endrole

@hasrole('instructor')
    <!-- Instructor content -->
@endhasrole

@hasanyrole('admin|superadmin')
    <!-- Admin or Superadmin content -->
@endhasanyrole

@can('edit-posts')
    <!-- Has permission -->
@endcan
```

### Middleware Usage
```php
// In routes
Route::middleware(['spatie.role:admin'])->group(function () {
    // Routes for admin only
});

Route::middleware(['spatie.permission:edit-posts'])->group(function () {
    // Routes for users with edit-posts permission
});

// Combined role or permission
Route::middleware(['spatie.role_or_permission:admin|edit-posts'])->group(function () {
    // Routes for admin OR users with edit-posts permission
});
```

---

## 🚀 Post-Migration Steps

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Clear Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### 3. Re-seed Roles (Optional)
```bash
php artisan db:seed --class=RoleSeeder
```

### 4. Clear Spatie Permission Cache
```bash
php artisan permission:cache-reset
```

---

## ⚠️ Important Notes

1. **No more `user_type`**: All role checks are now through `model_has_roles` table
2. **Single source of truth**: Only Spatie's `roles` table defines roles
3. **Admin users**: Admin/Superadmin are regular User records with admin/superadmin roles
4. **Helper methods**: `isSuperAdmin()`, `isAdmin()`, etc. internally use `hasRole()`

---

## 📊 Role Hierarchy

| Role | Description | Permissions |
|------|-------------|-------------|
| `superadmin` | Full system access | All permissions |
| `admin` | Admin dashboard access | Limited admin permissions |
| `instructor` | Course management | Course CRUD, live classes, wallet |
| `student` | Learning access | View courses, enroll, reviews |

---

## 🔄 Before vs After

### Before (Custom Logic)
```php
// ❌ Don't use
if ($user->user_type === 'instructor') { ... }
if ($user->role_id === 2) { ... }
```

### After (Spatie)
```php
// ✅ Use these
if ($user->hasRole('instructor')) { ... }
if ($user->isInstructor()) { ... }  // Uses hasRole internally
```

---

## 📁 Final File Structure

```
app/
├── Models/
│   └── User.php              # With HasRoles trait
├── Http/
│   ├── Controllers/
│   │   └── Admin/
│   │       ├── AdminRoleController.php      # Uses Spatie Role
│   │       ├── AdminPermissionController.php # Uses Spatie Permission
│   │       └── AdminAccountController.php    # Uses User with roles
│   └── Middleware/
│       ├── RoleMiddleware.php     # Uses hasRole()
│       ├── AdminMiddleware.php    # Uses hasRole()
│       ├── SuperAdminMiddleware.php # Uses hasRole()
│       ├── InstructorMiddleware.php # Uses hasRole()
│       └── StudentMiddleware.php    # Uses hasRole()
config/
└── permission.php            # Spatie configuration
```

---

## ✨ Best Practices

1. **Always use Spatie methods**: `hasRole()`, `hasPermissionTo()`, `can()`
2. **Cache permissions**: Run `php artisan permission:cache-reset` after changes
3. **Use blade directives**: `@role`, `@hasrole`, `@can` for cleaner templates
4. **Guard consistency**: Always use 'web' guard (configured in config/permission.php)
5. **Seed roles on deploy**: Include RoleSeeder in deployment process
