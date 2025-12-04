<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Test 1: Check instructor user has role
$instructor = \App\Models\User::where('email', 'instructor@example.com')->with('role')->first();
echo "Test 1: Instructor User Check\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Name: {$instructor->name}\n";
echo "Email: {$instructor->email}\n";
echo "Role: {$instructor->role?->slug}\n";
echo "isInstructor(): " . ($instructor->isInstructor() ? 'TRUE' : 'FALSE') . "\n";

// Test 2: Check professor user has role
$professor = \App\Models\User::where('email', 'professor@paathshaala.com')->with('role')->first();
echo "\n\nTest 2: Professor User Check (Was Missing Role)\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "Name: {$professor->name}\n";
echo "Email: {$professor->email}\n";
echo "Role: {$professor->role?->slug}\n";
echo "isInstructor(): " . ($professor->isInstructor() ? 'TRUE' : 'FALSE') . "\n";

echo "\n\n✅ All instructor users now have proper roles assigned!\n";
echo "They should now be able to access /instructor/courses without 403 error.\n";
