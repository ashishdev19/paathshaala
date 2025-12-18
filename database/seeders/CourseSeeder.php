<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teacher = User::role('instructor')->first();
        
        // Get categories
        $medicalScience = CourseCategory::where('name', 'Medical Pharmacology')->first();
        $healthcareManagement = CourseCategory::where('name', 'Healthcare Management')->first();

        if ($teacher && $medicalScience && $healthcareManagement) {
            Course::create([
                'title' => 'Introduction to Medical Diagnostics',
                'description' => 'Learn the basics of diagnosing common medical conditions and understand various diagnostic tools and techniques.',
                'category_id' => $medicalScience->id,
                'price' => 5000.00,
                'thumbnail' => 'images/courses/medical-diagnostics-thumb.jpg',
                'banner' => 'images/courses/medical-diagnostics-banner.jpg',
                'syllabus' => [
                    'Module 1: Basics of Diagnosis',
                    'Module 2: Diagnostic Tools',
                    'Module 3: Case Studies',
                    'Module 4: Practical Applications'
                ],
                'teacher_id' => $teacher->id,
                'is_featured' => true,
                'is_active' => true,
                'duration_hours' => 40,
                'level' => 'beginner',
            ]);

            Course::create([
                'title' => 'Healthcare Management Essentials',
                'description' => 'Understand key principles of managing healthcare facilities and learn about operational efficiency.',
                'category_id' => $healthcareManagement->id,
                'price' => 6000.00,
                'thumbnail' => 'images/courses/healthcare-management-thumb.jpg',
                'banner' => 'images/courses/healthcare-management-banner.jpg',
                'syllabus' => [
                    'Module 1: Introduction to Healthcare Management',
                    'Module 2: Financial Management',
                    'Module 3: Operational Efficiency',
                    'Module 4: Quality Assurance'
                ],
                'teacher_id' => $teacher->id,
                'is_featured' => true,
                'is_active' => true,
                'duration_hours' => 35,
                'level' => 'intermediate',
            ]);

            Course::create([
                'title' => 'Advanced Clinical Procedures',
                'description' => 'Master advanced techniques in clinical settings with hands-on practical training.',
                'category_id' => $medicalScience->id,
                'price' => 12000.00,
                'thumbnail' => 'images/courses/clinical-procedures-thumb.jpg',
                'banner' => 'images/courses/clinical-procedures-banner.jpg',
                'syllabus' => [
                    'Module 1: Advanced Diagnostic Techniques',
                    'Module 2: Surgical Procedures',
                    'Module 3: Patient Management',
                    'Module 4: Emergency Protocols'
                ],
                'teacher_id' => $teacher->id,
                'is_featured' => false,
                'is_active' => true,
                'duration_hours' => 60,
                'level' => 'advanced',
            ]);
        }
    }
}
