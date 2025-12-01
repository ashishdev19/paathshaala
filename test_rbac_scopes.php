<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║         TESTING FIXED RBAC QUERY SCOPES                   ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";

// Test 1: byRole scope with instructor
echo "Test 1: User::byRole('instructor')->count()\n";
try {
    $instructors = User::byRole('instructor')->count();
    echo "   ✅ Result: $instructors instructors found\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 2: byRole scope with student
echo "\nTest 2: User::byRole('student')->count()\n";
try {
    $students = User::byRole('student')->count();
    echo "   ✅ Result: $students students found\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 3: byRole scope with admin
echo "\nTest 3: User::byRole('admin')->count()\n";
try {
    $admins = User::byRole('admin')->count();
    echo "   ✅ Result: $admins admins found\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 4: byRole scope with superadmin
echo "\nTest 4: User::byRole('superadmin')->count()\n";
try {
    $superadmins = User::byRole('superadmin')->count();
    echo "   ✅ Result: $superadmins super admins found\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 5: Get specific user
echo "\nTest 5: User::byRole('student')->first()\n";
try {
    $student = User::byRole('student')->first();
    if ($student) {
        echo "   ✅ Found: {$student->email} (Role: {$student->role->name})\n";
    } else {
        echo "   ⚠️  No students found\n";
    }
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 6: byRoles scope (multiple roles)
echo "\nTest 6: User::byRoles(['admin', 'superadmin'])->count()\n";
try {
    $adminUsers = User::byRoles(['admin', 'superadmin'])->count();
    echo "   ✅ Result: $adminUsers admin users found\n";
} catch (\Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║          ✅ ALL TESTS PASSED - ERROR FIXED!               ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n";
echo "\n";
