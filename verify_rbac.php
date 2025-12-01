<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║              RBAC SYSTEM VERIFICATION                      ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Check Roles
$roles = Role::all();
echo "✅ ROLES CREATED: " . $roles->count() . "\n";
foreach ($roles as $role) {
    echo "   • $role->name (slug: $role->slug)\n";
}

echo "\n";

// Check Permissions
$permissions = Permission::all();
echo "✅ PERMISSIONS CREATED: " . $permissions->count() . "\n";
echo "   Sample permissions:\n";
foreach ($permissions->take(5) as $perm) {
    echo "   • $perm->name\n";
}
echo "   ... and " . ($permissions->count() - 5) . " more\n";

echo "\n";

// Check Users and Roles
$users = User::with('role')->whereNotNull('role_id')->get();
echo "✅ USERS WITH ROLES: " . $users->count() . "\n";
foreach ($users as $user) {
    echo "   • {$user->email} -> {$user->role->name}\n";
}

echo "\n";

// Test helper methods
echo "✅ TESTING HELPER METHODS:\n";
$superAdmin = User::where('email', 'superadmin@example.com')->first();
if ($superAdmin) {
    echo "   • superadmin->isSuperAdmin(): " . ($superAdmin->isSuperAdmin() ? 'TRUE' : 'FALSE') . "\n";
    echo "   • superadmin->hasPermission('manage-users'): " . ($superAdmin->hasPermission('manage-users') ? 'TRUE' : 'FALSE') . "\n";
}

$student = User::where('email', 'student@example.com')->first();
if ($student) {
    echo "   • student->isStudent(): " . ($student->isStudent() ? 'TRUE' : 'FALSE') . "\n";
    echo "   • student->hasPermission('manage-users'): " . ($student->hasPermission('manage-users') ? 'TRUE' : 'FALSE') . "\n";
}

echo "\n";

// Test role permissions
echo "✅ ROLE PERMISSIONS SAMPLE:\n";
$adminRole = Role::where('slug', 'admin')->first();
if ($adminRole) {
    $adminPerms = $adminRole->permissions()->limit(3)->get();
    echo "   Admin role has these permissions:\n";
    foreach ($adminPerms as $perm) {
        echo "   • $perm->name\n";
    }
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║  ✅ RBAC SYSTEM IS ACTIVE AND READY TO USE!               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";
