<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';

// Check routes without needing database
$routes = app('router')->getRoutes();
echo "All Instructor Routes:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$found = false;
foreach ($routes as $route) {
    if (strpos($route->uri(), 'instructor') !== false && strpos($route->uri(), 'courses') !== false) {
        echo "✅ Found route: {$route->uri()}\n";
        echo "   Methods: " . implode(', ', $route->methods()) . "\n";
        echo "   Middleware: " . implode(', ', $route->middleware()) . "\n";
        $found = true;
    }
}

if (!$found) {
    echo "Checking all routes containing 'instructor':\n";
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'instructor') !== false) {
            echo "  - {$route->uri()}\n";
        }
    }
}
