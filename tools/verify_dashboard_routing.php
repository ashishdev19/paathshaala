<?php

/**
 * Dashboard Routing Test
 * 
 * This script verifies the complete dashboard routing setup
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Route;

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║         DASHBOARD ROUTING VERIFICATION                         ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

// Check if routes are registered
$routes = [
    'admin.dashboard' => '/admin/dashboard',
    'teacher.dashboard' => '/teacher/dashboard',
    'student.dashboard' => '/student/dashboard',
    'dashboard' => '/dashboard',
];

echo "✓ Checking Route Registration:\n";
echo "─────────────────────────────────\n";

foreach ($routes as $name => $uri) {
    if (Route::has($name)) {
        $route = Route::getRoutes()->getByName($name);
        $action = $route->getActionName();
        echo "✅ {$name}\n";
        echo "   URI: {$uri}\n";
        echo "   Action: {$action}\n\n";
    } else {
        echo "❌ {$name} - NOT FOUND\n\n";
    }
}

// Check middleware registration
echo "\n✓ Checking Middleware Registration:\n";
echo "─────────────────────────────────────\n";

$middlewareAliases = app('router')->getMiddleware();

if (isset($middlewareAliases['role'])) {
    echo "✅ role middleware: " . $middlewareAliases['role'] . "\n";
} else {
    echo "❌ role middleware: NOT REGISTERED\n";
}

// Check controllers exist
echo "\n✓ Checking Controllers:\n";
echo "─────────────────────────\n";

$controllers = [
    'Admin\AdminController' => app_path('Http/Controllers/Admin/AdminController.php'),
    'Teacher\TeacherController' => app_path('Http/Controllers/Teacher/TeacherController.php'),
    'Student\StudentController' => app_path('Http/Controllers/Student/StudentController.php'),
    'Auth\CustomLoginController' => app_path('Http/Controllers/Auth/CustomLoginController.php'),
];

foreach ($controllers as $name => $path) {
    if (file_exists($path)) {
        echo "✅ {$name}\n";
    } else {
        echo "❌ {$name} - FILE NOT FOUND\n";
    }
}

// Check views exist
echo "\n✓ Checking Dashboard Views:\n";
echo "────────────────────────────\n";

$views = [
    'admin.dashboard' => resource_path('views/admin/dashboard.blade.php'),
    'teacher.dashboard' => resource_path('views/teacher/dashboard.blade.php'),
    'student.dashboard' => resource_path('views/student/dashboard.blade.php'),
];

foreach ($views as $name => $path) {
    if (file_exists($path)) {
        echo "✅ {$name}\n";
    } else {
        echo "❌ {$name} - FILE NOT FOUND\n";
    }
}

// Check role models
echo "\n✓ Checking Role System:\n";
echo "────────────────────────\n";

try {
    $roles = \Spatie\Permission\Models\Role::all()->pluck('name')->toArray();
    
    $requiredRoles = ['admin', 'teacher', 'student'];
    
    foreach ($requiredRoles as $role) {
        if (in_array($role, $roles)) {
            echo "✅ Role '{$role}' exists\n";
        } else {
            echo "⚠️  Role '{$role}' not found in database\n";
        }
    }
} catch (\Exception $e) {
    echo "❌ Error checking roles: " . $e->getMessage() . "\n";
}

echo "\n╔════════════════════════════════════════════════════════════════╗\n";
echo "║         VERIFICATION COMPLETE                                  ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

echo "📝 NEXT STEPS:\n";
echo "─────────────\n";
echo "1. Start MySQL service in Laragon\n";
echo "2. Run: php artisan migrate:fresh --seed\n";
echo "3. Login with role-based credentials:\n";
echo "   - Admin:   admin@paathshaala.com\n";
echo "   - Teacher: teacher@paathshaala.com\n";
echo "   - Student: student@paathshaala.com\n";
echo "4. Verify automatic dashboard redirect\n\n";
