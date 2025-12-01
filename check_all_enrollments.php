<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$student = App\Models\User::find(4);

$enrollments = App\Models\Enrollment::where('student_id', $student->id)
    ->with('course')
    ->get();

echo "Student: " . $student->name . " (ID: " . $student->id . ")\n";
echo "Total Enrollments: " . $enrollments->count() . "\n\n";

echo "Enrolled Courses:\n";
echo str_repeat("-", 80) . "\n";

foreach ($enrollments as $enrollment) {
    echo "Course ID: " . $enrollment->course_id . "\n";
    echo "Course Title: " . $enrollment->course->title . "\n";
    echo "Enrollment Status: " . $enrollment->status . "\n";
    echo "Payment Status: " . $enrollment->payment_status . "\n";
    echo str_repeat("-", 80) . "\n";
}
