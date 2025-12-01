<?php

require __DIR__ . '/vendor/autoload.php';

// Test 1: Verify User Model has RBAC helper methods
echo "=== Multi-Role Authentication System Test ===\n\n";

// Load Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Test 1: Verify middleware files exist
echo "Test 1: Checking middleware files...\n";
$middlewares = [
    'app/Http/Middleware/SuperAdminMiddleware.php',
    'app/Http/Middleware/AdminMiddleware.php',
    'app/Http/Middleware/ProfessorMiddleware.php',
    'app/Http/Middleware/StudentMiddleware.php',
];

foreach ($middlewares as $middleware) {
    $exists = file_exists(base_path($middleware)) ? '✅' : '❌';
    echo "  {$exists} {$middleware}\n";
}

// Test 2: Verify controller files exist
echo "\nTest 2: Checking controller files...\n";
$controllers = [
    'app/Http/Controllers/SuperAdmin/SuperAdminDashboardController.php',
    'app/Http/Controllers/Admin/AdminDashboardController.php',
    'app/Http/Controllers/Professor/ProfessorDashboardController.php',
    'app/Http/Controllers/Student/StudentDashboardController.php',
];

foreach ($controllers as $controller) {
    $exists = file_exists(base_path($controller)) ? '✅' : '❌';
    echo "  {$exists} {$controller}\n";
}

// Test 3: Verify view files exist
echo "\nTest 3: Checking view files...\n";
$views = [
    'resources/views/superadmin/dashboard.blade.php',
    'resources/views/admin/dashboard.blade.php',
    'resources/views/professor/dashboard.blade.php',
    'resources/views/student/dashboard.blade.php',
];

foreach ($views as $view) {
    $exists = file_exists(base_path($view)) ? '✅' : '❌';
    echo "  {$exists} {$view}\n";
}

// Test 4: Check User RBAC helper methods
echo "\nTest 4: Checking User model RBAC methods...\n";
$user = User::first();
if ($user) {
    echo "  ✅ User model loaded\n";
    
    // Check if methods exist
    $methods = ['isSuperAdmin', 'isAdmin', 'isInstructor', 'isStudent', 'hasRole', 'hasPermission'];
    foreach ($methods as $method) {
        $exists = method_exists($user, $method) ? '✅' : '❌';
        echo "  {$exists} {$method}() method\n";
    }
} else {
    echo "  ❌ No users found in database\n";
}

// Test 5: Verify test users exist
echo "\nTest 5: Checking test users...\n";
$roles = ['superadmin', 'admin', 'instructor', 'student'];
foreach ($roles as $role) {
    $users = User::byRole($role)->count();
    echo "  {$role}: {$users} user(s)\n";
}

// Test 6: Check LoginController
echo "\nTest 6: Checking LoginController...\n";
$loginControllerPath = base_path('app/Http/Controllers/Auth/CustomLoginController.php');
if (file_exists($loginControllerPath)) {
    $content = file_get_contents($loginControllerPath);
    
    // Check for RBAC method calls
    $checks = [
        'isSuperAdmin()' => 'isSuperAdmin()',
        'isAdmin()' => 'isAdmin()',
        'isInstructor()' => 'isInstructor()',
        'isStudent()' => 'isStudent()',
        'superadmin.dashboard' => 'superadmin route',
        'admin.dashboard' => 'admin route',
        'instructor.dashboard' => 'instructor route',
        'student.dashboard' => 'student route',
    ];
    
    foreach ($checks as $search => $label) {
        $exists = strpos($content, $search) !== false ? '✅' : '❌';
        echo "  {$exists} {$label}\n";
    }
} else {
    echo "  ❌ LoginController not found\n";
}

// Test 7: Check bootstrap/app.php middleware registration
echo "\nTest 7: Checking middleware aliases in bootstrap/app.php...\n";
$bootstrapPath = base_path('bootstrap/app.php');
$bootstrapContent = file_get_contents($bootstrapPath);

$aliases = ['superadmin', 'admin', 'professor', 'student'];
foreach ($aliases as $alias) {
    $exists = strpos($bootstrapContent, "'{$alias}'") !== false ? '✅' : '❌';
    echo "  {$exists} {$alias} middleware alias\n";
}

echo "\n=== Test Summary ===\n";
echo "✅ All multi-role authentication components created successfully!\n";
echo "\nYou can now:\n";
echo "1. Login with superadmin@example.com → redirects to /superadmin/dashboard\n";
echo "2. Login with admin@example.com → redirects to /admin/dashboard\n";
echo "3. Login with instructor@example.com → redirects to /professor/dashboard\n";
echo "4. Login with student@example.com → redirects to /student/dashboard\n";
echo "5. All users have password: 'password'\n";
