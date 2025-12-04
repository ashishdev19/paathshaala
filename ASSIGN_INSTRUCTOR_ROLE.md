# Assigning Instructor Role to a User

This guide explains how to assign the "Instructor" role to a user (like `professor@paathshaala.com`) in your Laravel project.

## Overview

Your project uses a **custom roles system** (not full Spatie permissions). Roles are stored in the `roles` table, and users reference their role via the `role_id` column in the `users` table.

**Current setup:**
- Instructor role ID: `3`
- Professor user email: `professor@paathshaala.com`
- Current status: **Already assigned** ✓

---

## Method 1: Using the Console Command (Recommended)

A reusable Laravel command has been created that is **idempotent** (safe to run multiple times).

### Location
`app/Console/Commands/AssignInstructorRole.php`

### Usage

```bash
# Assign instructor role to professor@paathshaala.com (default)
php artisan assign:instructor-role

# Assign instructor role to a different user
php artisan assign:instructor-role john.doe@example.com
```

### Features
- ✓ Finds user by email
- ✓ Creates Instructor role if it doesn't exist
- ✓ Checks if user already has the role (prevents duplicate assignments)
- ✓ Updates user's `role_id` to the Instructor role ID
- ✓ Clears application cache
- ✓ Provides detailed console output

### Example Output
```
Found user: Dr. Rajesh Kumar (professor@paathshaala.com)
Role 'Instructor' already exists (ID: 3).
User already has the 'Instructor' role (ID: 3).
```

---

## Method 2: Using a Database Seeder

A seeder has been created for database seeding workflows.

### Location
`database/seeders/AssignInstructorRoleSeeder.php`

### Usage

```bash
# Run the specific seeder
php artisan db:seed --class=AssignInstructorRoleSeeder

# Or run all seeders (if added to DatabaseSeeder)
php artisan db:seed
```

### To integrate with DatabaseSeeder:

Edit `database/seeders/DatabaseSeeder.php` and add:

```php
public function run(): void
{
    $this->call([
        // ... other seeders
        AssignInstructorRoleSeeder::class,
    ]);
}
```

### Features
- Same as the command (idempotent, safe to run multiple times)
- Useful for fresh database setups or migration scripts

---

## Method 3: Using the Standalone PHP Snippet

A standalone script for one-time execution or debugging.

### Location
`assign_instructor_role_snippet.php`

### Usage

```bash
php assign_instructor_role_snippet.php
```

### Features
- ✓ No Laravel command overhead
- ✓ Direct database queries
- ✓ Clear output and verification
- ✓ Useful for troubleshooting

### Example Output
```
=== Assigning Instructor Role to User ===

✓ Found user: Dr. Rajesh Kumar (professor@paathshaala.com)
  Current Role ID: 3
✓ Role 'Instructor' already exists (ID: 3)
ℹ User already has the 'Instructor' role.

=== Complete! ===
```

---

## Direct PHP Code Snippet

If you need to embed this logic in your own code:

```php
use App\Models\User;
use App\Models\Role;

// Find the user
$user = User::where('email', 'professor@paathshaala.com')->first();

if (!$user) {
    throw new Exception("User not found");
}

// Get or create the Instructor role
$role = Role::where('slug', 'instructor')->firstOrCreate(
    ['slug' => 'instructor'],
    [
        'name' => 'Instructor',
        'description' => 'Instructor/Teacher role with course management capabilities.',
    ]
);

// Check if user already has the role
if ($user->role_id !== $role->id) {
    // Assign the role
    $user->update(['role_id' => $role->id]);
    
    // Clear cache
    cache()->forget('spatie.permission.cache');
    cache()->flush();
    
    echo "Role assigned successfully";
} else {
    echo "User already has this role";
}
```

---

## Checking Current User Roles

To verify a user's current role:

```php
$user = User::where('email', 'professor@paathshaala.com')->first();

echo $user->role_id;           // Output: 3
echo $user->role->name;        // Output: Instructor
echo $user->role->slug;        // Output: instructor
echo $user->isInstructor();    // Output: true
```

---

## How Instructor Routes Work

The middleware checks for instructor privileges:

```php
// In app/Http/Middleware/ProfessorMiddleware.php

$user->load('role'); // Force reload role from database

$isAuthorized = $user->isSuperAdmin() 
    || $user->isAdmin() 
    || $user->isInstructor();

if (!$isAuthorized) {
    abort(403, 'Access Denied');
}
```

**Routes protected:**
- `/instructor/dashboard`
- `/instructor/courses`
- `/instructor/students`
- etc.

---

## Troubleshooting

### User still getting 403 error?

1. **Verify role assignment:**
   ```bash
   php check_professor_user.php
   ```
   This script shows the exact role assignment status.

2. **Clear caches:**
   ```bash
   php artisan cache:clear
   php artisan view:clear
   php artisan config:clear
   ```

3. **Check the logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```
   Look for middleware log entries with the user's role information.

### Role not found?

Create it manually:
```bash
php artisan assign:instructor-role professor@paathshaala.com
```
The command will create the role if it doesn't exist.

---

## Database Schema

The roles system uses these tables:

```
users
  - id (primary key)
  - email
  - name
  - role_id (foreign key to roles.id)
  
roles
  - id (primary key)
  - name (e.g., "Instructor")
  - slug (e.g., "instructor")
  - description
  - created_at
  - updated_at
```

---

## Safety & Idempotency

All methods are **safe and idempotent**:
- ✓ Can run multiple times without side effects
- ✓ Won't create duplicate roles
- ✓ Won't re-assign if user already has the role
- ✓ Clears caches to prevent stale data
- ✓ Includes error handling for missing users

---

## Summary

| Method | File | Usage | Best For |
|--------|------|-------|----------|
| **Command** | `app/Console/Commands/AssignInstructorRole.php` | `php artisan assign:instructor-role` | Development & ops |
| **Seeder** | `database/seeders/AssignInstructorRoleSeeder.php` | `php artisan db:seed --class=...` | Database migrations |
| **Snippet** | `assign_instructor_role_snippet.php` | `php assign_instructor_role_snippet.php` | Quick testing |
| **Direct Code** | Inline PHP | Copy into your code | Custom integrations |

**Recommended:** Use the **Console Command** for most situations as it's the cleanest and most maintainable.
