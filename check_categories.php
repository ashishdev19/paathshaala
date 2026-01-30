<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Current course categories in database:\n\n";

$categories = DB::table('course_categories')->get(['id', 'name', 'icon']);

foreach ($categories as $category) {
    echo "ID: {$category->id} | Name: {$category->name} | Icon: {$category->icon}\n";
}

echo "\nTotal: " . count($categories) . " categories\n";
