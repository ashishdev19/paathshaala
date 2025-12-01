<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$student = App\Models\User::find(4);
$courseId = 11;

$enrollment = App\Models\Enrollment::where('student_id', $student->id)
    ->where('course_id', $courseId)
    ->first();

echo "Student ID: " . $student->id . "\n";
echo "Student Name: " . $student->name . "\n";
echo "Course ID: " . $courseId . "\n";
echo "Is Enrolled: " . ($enrollment ? 'YES' : 'NO') . "\n";

if ($enrollment) {
    echo "Enrollment ID: " . $enrollment->id . "\n";
    echo "Status: " . $enrollment->status . "\n";
    echo "Payment Status: " . $enrollment->payment_status . "\n";
}
