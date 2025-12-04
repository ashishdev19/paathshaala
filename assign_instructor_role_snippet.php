<?php
/**
 * Standalone PHP snippet to assign Instructor role to a user
 * Works with the custom Roles system (not full Spatie)
 * 
 * Usage: php assign_instructor_role_snippet.php
 */

// Load Laravel
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;

// Configuration
$userEmail = 'professor@paathshaala.com';
$roleName = 'Instructor';
$roleSlug = 'instructor';

echo "=== Assigning Instructor Role to User ===\n\n";

// 1. Find the user
$user = User::where('email', $userEmail)->first();

if (!$user) {
    echo "❌ User with email '{$userEmail}' not found.\n";
    exit(1);
}

echo "✓ Found user: {$user->name} ({$user->email})\n";
echo "  Current Role ID: " . ($user->role_id ?? 'NULL') . "\n";

// 2. Get or create the Instructor role
$role = Role::where('slug', $roleSlug)->first();

if (!$role) {
    $role = Role::create([
        'name' => $roleName,
        'slug' => $roleSlug,
        'description' => 'Instructor/Teacher role with course management capabilities.',
    ]);
    echo "✓ Created new role: '{$roleName}' (ID: {$role->id})\n";
} else {
    echo "✓ Role '{$roleName}' already exists (ID: {$role->id})\n";
}

// 3. Check if user already has the role
if ($user->role_id === $role->id) {
    echo "ℹ User already has the '{$roleName}' role.\n";
    echo "\n=== Complete! ===\n";
    exit(0);
}

// 4. Assign the role
$user->update(['role_id' => $role->id]);
echo "✓ Assigned '{$roleName}' role (ID: {$role->id}) to {$user->name}.\n";

// 5. Clear caches
app()['cache']->forget('spatie.permission.cache');
app()['cache']->flush();
echo "✓ Application cache cleared.\n";

// 6. Verify
$user->refresh();
echo "✓ Verification: User role_id is now {$user->role_id}\n";

echo "\n=== Complete! ===\n";
echo "User '{$user->email}' now has the '{$roleName}' role.\n";
echo "The user can now access instructor routes via middleware checks.\n";

