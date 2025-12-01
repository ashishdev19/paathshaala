<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$course = App\Models\Course::find(19);

echo "Thumbnail path in DB: " . $course->thumbnail . "\n";
echo "Full URL should be: " . asset('storage/' . $course->thumbnail) . "\n";
echo "\n";
echo "File exists at: c:\\laragon\\www\\paathshaala\\storage\\app\\public\\" . $course->thumbnail . "\n";

$fullPath = "c:\\laragon\\www\\paathshaala\\storage\\app\\public\\" . $course->thumbnail;
echo "File exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
