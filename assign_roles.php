<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Assign instructor role to professor and teacher users
$professorUser = \App\Models\User::where('email', 'professor@paathshaala.com')->first();
$teacherUser = \App\Models\User::where('email', 'teacher@paathshaala.com')->first();
$adminUser = \App\Models\User::where('email', 'admin@paathshaala.com')->first();

$instructorRole = \App\Models\Role::where('slug', 'instructor')->first();
$adminRole = \App\Models\Role::where('slug', 'admin')->first();
$studentRole = \App\Models\Role::where('slug', 'student')->first();

if ($professorUser && $instructorRole) {
    $professorUser->update(['role_id' => $instructorRole->id]);
    echo "✅ Assigned 'instructor' role to Dr. Rajesh Kumar (professor@paathshaala.com)\n";
}

if ($teacherUser && $instructorRole) {
    $teacherUser->update(['role_id' => $instructorRole->id]);
    echo "✅ Assigned 'instructor' role to Prof. Priya Sharma (teacher@paathshaala.com)\n";
}

if ($adminUser && $adminRole) {
    $adminUser->update(['role_id' => $adminRole->id]);
    echo "✅ Assigned 'admin' role to Admin User (admin@paathshaala.com)\n";
}

// Assign student role to student users
$studentEmails = [
    'student@paathshaala.com',
    'student2@paathshaala.com',
    'teststudent1@paathshaala.com',
    'teststudent2@paathshaala.com',
    'teststudent3@paathshaala.com',
    'teststudent4@paathshaala.com',
    'teststudent5@paathshaala.com',
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
