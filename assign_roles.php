<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Assign instructor role to professor and teacher users
$professorUser = \App\Models\User::where('email', 'professor@medniks.com')->first();
$teacherUser = \App\Models\User::where('email', 'teacher@medniks.com')->first();
$adminUser = \App\Models\User::where('email', 'admin@medniks.com')->first();

$instructorRole = \App\Models\Role::where('slug', 'instructor')->first();
$adminRole = \App\Models\Role::where('slug', 'admin')->first();
$studentRole = \App\Models\Role::where('slug', 'student')->first();

if ($professorUser && $instructorRole) {
    $professorUser->update(['role_id' => $instructorRole->id]);
    echo "✅ Assigned 'instructor' role to Dr. Rajesh Kumar (professor@medniks.com)\n";
}

if ($teacherUser && $instructorRole) {
    $teacherUser->update(['role_id' => $instructorRole->id]);
    echo "✅ Assigned 'instructor' role to Prof. Priya Sharma (teacher@medniks.com)\n";
}

if ($adminUser && $adminRole) {
    $adminUser->update(['role_id' => $adminRole->id]);
    echo "✅ Assigned 'admin' role to Admin User (admin@medniks.com)\n";
}

// Assign student role to student users
$studentEmails = [
    'student@medniks.com',
    'student2@medniks.com',
    'teststudent1@medniks.com',
    'teststudent2@medniks.com',
    'teststudent3@medniks.com',
    'teststudent4@medniks.com',
    'teststudent5@medniks.com',
];

foreach ($studentEmails as $email) {
    $student = \App\Models\User::where('email', $email)->first();
    if ($student && $studentRole) {
        $student->update(['role_id' => $studentRole->id]);
        echo "✅ Assigned 'student' role to {$student->name} ({$email})\n";
    }
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "All users have been assigned appropriate roles!\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
