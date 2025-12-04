<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Check instructor@example.com specifically
$instructor = \App\Models\User::where('email', 'instructor@example.com')->with('role')->first();

echo "Checking instructor@example.com User Details:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

if (!$instructor) {
    echo "❌ User not found!\n";
    exit(1);
}

echo "ID: {$instructor->id}\n";
echo "Name: {$instructor->name}\n";
echo "Email: {$instructor->email}\n";
echo "Role ID: {$instructor->role_id}\n";
echo "Role Object: " . (is_null($instructor->role) ? 'NULL' : 'Loaded') . "\n";

if ($instructor->role) {
    echo "Role Slug: {$instructor->role->slug}\n";
    echo "Role Name: {$instructor->role->name}\n";
} else {
    echo "❌ PROBLEM: User has NO ROLE assigned (role_id is NULL or invalid)\n";
}

echo "\nMethod Checks:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "isSuperAdmin(): " . ($instructor->isSuperAdmin() ? 'TRUE ✅' : 'FALSE ❌') . "\n";
echo "isAdmin(): " . ($instructor->isAdmin() ? 'TRUE ✅' : 'FALSE ❌') . "\n";
echo "isInstructor(): " . ($instructor->isInstructor() ? 'TRUE ✅' : 'FALSE ❌') . "\n";
echo "isStudent(): " . ($instructor->isStudent() ? 'TRUE ✅' : 'FALSE ❌') . "\n";

echo "\nMiddleware Check:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$canAccess = $instructor->isSuperAdmin() || $instructor->isAdmin() || $instructor->isInstructor() || ($instructor->role?->slug === 'teacher');
echo "Can access instructor routes: " . ($canAccess ? '✅ YES' : '❌ NO') . "\n";

if (!$canAccess) {
    echo "\n⚠️ This user CANNOT access /instructor/courses\n";
    echo "Assigning instructor role now...\n\n";
    
    $instructorRole = \App\Models\Role::where('slug', 'instructor')->first();
    if ($instructorRole) {
        $instructor->role_id = $instructorRole->id;
        $instructor->save();
        echo "✅ Assigned role_id = {$instructorRole->id} (instructor role)\n";
        echo "✅ User can now access instructor routes!\n";
    } else {
        echo "❌ ERROR: instructor role not found in database!\n";
    }
}
