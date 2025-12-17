<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CourseCategory;

class CourseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Medical Coding & Billing',
            'Medical Transcription',
            'Hospital Administration',
            'Healthcare Management',
            'Clinical Research',
            'Medical Ethics & Law',
            'Digital Health & Telemedicine',
            'Electronic Health Records (EHR)',
            'Medical Pharmacology',
            'Pathology Basics',
            'Microbiology Theory',
            'Clinical Biochemistry',
            'Medical Laboratory Technology (MLT – Theory)',
            'Radiology & Imaging Theory',
            'First Aid & CPR',
            'Basic Life Support (BLS – Theory)',
            'Advanced Cardiac Life Support (ACLS – Theory)',
            'Trauma & Emergency Care (Theory)',
            'Infection Control & Hospital Safety',
            'ICU Nursing (Theory)',
            'Neonatal Nursing (Theory)',
            'Geriatric Care Training',
            'Home Nursing & Patient Care',
            'Mental Health Counseling',
            'Clinical Psychology Basics',
            'Stress & Anxiety Management',
            'Yoga Therapy',
            'Diet & Nutrition',
            'Ayurveda Lifestyle Course',
            'AI in Healthcare (Intro)',
            'Bioinformatics (Intro)',
            'Medical Statistics',
            'SPSS for Medical Research',
            'NEET UG Preparation',
            'NEET PG / NEXT Preparation',
            'Nursing Entrance Coaching',
            'Paramedical Entrance Coaching',
            'Hospital Front Desk & Patient Management',
            'Clinical Documentation Training',
            'Medical English Communication',
            'Telemedicine Operator Training',
            'Other',
        ];

        foreach ($categories as $category) {
            CourseCategory::firstOrCreate(
                ['name' => $category],
                ['status' => 'active']
            );
        }

        $this->command->info('Course categories seeded successfully!');
    }
}
