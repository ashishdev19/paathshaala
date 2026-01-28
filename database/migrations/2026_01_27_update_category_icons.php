<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update category icons to match the colorful specialty icons
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

        foreach ($categories as $name => $iconClass) {
            DB::table('course_categories')
                ->where('name', $name)
                ->update(['icon_class' => $iconClass]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old icons
        $categories = [
            'Advanced Cardiac Life Support (ACLS – Theory)' => 'fa-stethoscope',
            'AI in Healthcare (Intro)' => 'fa-stethoscope',
            'Ayurveda Lifestyle Course' => 'fa-stethoscope',
            'Basic Life Support (BLS – Theory)' => 'fa-stethoscope',
            'Bioinformatics (Intro)' => 'fa-stethoscope',
            'Clinical Biochemistry' => 'fa-syringe',
            'Clinical Documentation Training' => 'fa-syringe',
            'Clinical Psychology Basics' => 'fa-syringe',
            'Clinical Research' => 'fa-syringe',
            'Diet & Nutrition' => 'fa-stethoscope',
            'Digital Health & Telemedicine' => 'fa-stethoscope',
            'Electronic Health Records (EHR)' => 'fa-stethoscope',
        ];

        foreach ($categories as $name => $iconClass) {
            DB::table('course_categories')
                ->where('name', $name)
                ->update(['icon_class' => $iconClass]);
        }
    }
};
