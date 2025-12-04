<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Create mock request for instructor
$request = new \Illuminate\Http\Request();
$request->setUserResolver(function () {
    return \App\Models\User::where('email', 'professor@paathshaala.com')->with('role')->first();
});

$middleware = new \App\Http\Middleware\ProfessorMiddleware();

echo "Testing ProfessorMiddleware for Instructor User\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$user = $request->user();
echo "User: {$user->name}\n";
echo "Email: {$user->email}\n";
echo "Role: {$user->role->slug}\n";
echo "isInstructor(): " . ($user->isInstructor() ? 'TRUE' : 'FALSE') . "\n";

// Test the handle method
try {
    $result = $middleware->handle($request, function ($req) {
        return "✅ Middleware passed!";
    });
    
    echo "\n$result\n";
    echo "\nInstructor can now access instructor routes!\n";
} catch (\Illuminate\Auth\AuthorizationException $e) {
    echo "\n❌ Middleware failed: " . $e->getMessage() . "\n";
}
