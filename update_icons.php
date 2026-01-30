<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Update all category icons
$categories = [
    'Advanced Cardiac Life Support (ACLS – Theory)' => 'fa-lungs',
    'AI in Healthcare (Intro)' => 'fa-robot',
    'Ayurveda Lifestyle Course' => 'fa-leaf',
    'Basic Life Support (BLS – Theory)' => 'fa-heart-pulse',
    'Bioinformatics (Intro)' => 'fa-dna',
    'Clinical Biochemistry' => 'fa-flask',
    'Clinical Documentation Training' => 'fa-clipboard-list',
    'Clinical Psychology Basics' => 'fa-brain',
    'Clinical Research' => 'fa-microscope',
    'Diet & Nutrition' => 'fa-apple-whole',
    'Digital Health & Telemedicine' => 'fa-laptop-medical',
    'Electronic Health Records (EHR)' => 'fa-file-medical',
];

echo "Updating course category icons...\n\n";

foreach ($categories as $name => $iconClass) {
    $updated = DB::table('course_categories')
        ->where('name', $name)
        ->update(['icon' => $iconClass]);
    
    if ($updated > 0) {
        echo "✓ Updated: $name -> $iconClass\n";
    } else {
        echo "✗ Not found: $name\n";
    }
}

echo "\nDone!\n";
