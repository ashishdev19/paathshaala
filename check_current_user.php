<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the most recently authenticated user from the database
// by checking the created_at or checking sessions
$lastUser = \App\Models\User::latest('id')->first();

echo "Last Created User in Database:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "ID: {$lastUser->id}\n";
echo "Name: {$lastUser->name}\n";
echo "Email: {$lastUser->email}\n";
echo "Role ID: {$lastUser->role_id}\n";
echo "Role: {$lastUser->role?->slug}\n";
echo "isSuperAdmin: " . ($lastUser->isSuperAdmin() ? 'TRUE' : 'FALSE') . "\n";
echo "isAdmin: " . ($lastUser->isAdmin() ? 'TRUE' : 'FALSE') . "\n";
echo "isInstructor: " . ($lastUser->isInstructor() ? 'TRUE' : 'FALSE') . "\n";
echo "isStudent: " . ($lastUser->isStudent() ? 'TRUE' : 'FALSE') . "\n";

echo "\n\nCheck if user would pass ProfessorMiddleware:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$passes = $lastUser->isSuperAdmin() || $lastUser->isAdmin() || $lastUser->isInstructor() || ($lastUser->role?->slug === 'teacher');
echo "Would pass middleware: " . ($passes ? '✅ YES' : '❌ NO') . "\n";

if (!$passes) {
    echo "\n❌ This user cannot access instructor routes!\n";
    echo "They need the 'instructor' or 'teacher' role.\n";
}
