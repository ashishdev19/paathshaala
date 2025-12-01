<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$course = App\Models\Course::find(19);

echo "Course ID: " . $course->id . "\n";
echo "Title: " . $course->title . "\n";
echo "Thumbnail: " . ($course->thumbnail ?? 'NULL') . "\n";
echo "Image: " . ($course->image ?? 'NULL') . "\n";
echo "Banner: " . ($course->banner ?? 'NULL') . "\n";
