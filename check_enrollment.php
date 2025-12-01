<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;

echo "=== Enrollment Check ===\n\n";

// Check user 4 enrollments
$user = User::find(4);
if ($user) {
    echo "User: {$user->name} ({$user->email})\n";
    echo "Role: " . ($user->roles->first()->name ?? 'No role') . "\n\n";
    
    $enrollments = Enrollment::where('student_id', 4)->with('course')->get();
    
    echo "Total Enrollments: " . $enrollments->count() . "\n\n";
    
    if ($enrollments->count() > 0) {
        foreach ($enrollments as $enrollment) {
            echo "ID: {$enrollment->id}\n";
            echo "Course: {$enrollment->course->title}\n";
            echo "Status: {$enrollment->status}\n";
            echo "Payment Status: {$enrollment->payment_status}\n";
            echo "Enrolled At: {$enrollment->enrolled_at}\n";
            echo "---\n";
        }
    } else {
        echo "No enrollments found!\n";
    }
} else {
    echo "User with ID 4 not found!\n";
}

// Check course 19
echo "\n=== Course 19 Info ===\n";
$course = Course::find(19);
if ($course) {
    echo "Course: {$course->title}\n";
    echo "Price: ₹{$course->price}\n";
    echo "Total Enrollments: " . Enrollment::where('course_id', 19)->count() . "\n";
} else {
    echo "Course 19 not found!\n";
}
