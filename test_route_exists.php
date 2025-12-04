<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

// Simulate the HTTP request
$request = \Illuminate\Http\Request::create('/instructor/courses', 'GET');
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');

// Set up a fake authenticated user as instructor
$instructor = \App\Models\User::where('email', 'instructor@example.com')->with('role')->first();

// Test if we can simulate the request
echo "Testing /instructor/courses route access:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "User: {$instructor->name} ({$instructor->email})\n";
echo "Role: {$instructor->role->slug}\n";
echo "isInstructor(): " . ($instructor->isInstructor() ? 'TRUE ✅' : 'FALSE ❌') . "\n\n";

// Check if the routes are registered
$routes = app('router')->getRoutes();
echo "Looking for /instructor/courses route...\n";

$found = false;
foreach ($routes as $route) {
    if (strpos($route->uri(), 'instructor/courses') !== false) {
        echo "✅ Found route: {$route->uri()}\n";
        echo "   Methods: " . implode(', ', $route->methods()) . "\n";
        echo "   Middleware: " . implode(', ', $route->middleware()) . "\n";
        echo "   Controller: " . ($route->getControllerClass() ?? 'Not found') . "\n";
        $found = true;
    }
}

if (!$found) {
    echo "❌ Route /instructor/courses NOT FOUND in registered routes!\n";
    echo "\nAll instructor routes:\n";
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'instructor') !== false) {
            echo "  - {$route->uri()}\n";
        }
    }
}
