<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSection;
use App\Models\CourseLecture;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    public function run(): void
    {
        // Get a teacher user or create one
        $teacher = User::byRole('instructor')->first();
        if (!$teacher) {
            $teacher = User::factory()->create();
            $teacher->assignRole('instructor');
        }

        // Create sample courses
        $courses = [
            [
                'title' => 'Advanced Medical Anatomy',
                'subtitle' => 'Comprehensive study of human body systems',
                'description' => 'Learn the intricate details of human anatomy with interactive 3D models and detailed explanations of all major body systems.',
                'category' => 'Medical',
                'level' => 'advanced',
                'language' => 'English',
                'course_mode' => 'online',
                'price' => 4999,
                'is_free' => false,
                'discount_price' => 3999,
                'validity_days' => 365,
                'teacher_id' => $teacher->id,
                'status' => 'published',
                'is_active' => true,
                'meta_title' => 'Advanced Medical Anatomy Course - Online Learning',
                'meta_description' => 'Learn comprehensive human anatomy with interactive models and expert instruction.',
                'slug' => 'advanced-medical-anatomy',
            ],
            [
                'title' => 'Nursing Fundamentals',
                'subtitle' => 'Essential skills for nursing professionals',
                'description' => 'Master the fundamental concepts and practical skills needed for nursing practice in modern healthcare settings.',
                'category' => 'Nursing',
                'level' => 'beginner',
                'language' => 'Hindi',
                'course_mode' => 'hybrid',
                'price' => 2999,
                'is_free' => false,
                'discount_price' => null,
                'validity_days' => 180,
                'teacher_id' => $teacher->id,
                'status' => 'published',
                'is_active' => true,
                'meta_title' => 'Nursing Fundamentals Course',
                'meta_description' => 'Complete nursing skills training for beginners and professionals.',
                'slug' => 'nursing-fundamentals',
            ],
            [
                'title' => 'Pharmacology Essentials',
                'subtitle' => 'Drug interactions and clinical applications',
                'description' => 'Understand drug mechanisms, interactions, and clinical applications in modern pharmacy practice.',
                'category' => 'Pharmacy',
                'level' => 'intermediate',
                'language' => 'English',
                'course_mode' => 'online',
                'price' => 3499,
                'is_free' => false,
                'discount_price' => 2499,
                'validity_days' => 365,
                'teacher_id' => $teacher->id,
                'status' => 'draft',
                'is_active' => false,
                'meta_title' => 'Pharmacology Essentials',
                'meta_description' => 'Learn essential pharmacology concepts for pharmacy professionals.',
                'slug' => 'pharmacology-essentials',
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);

            // Create sections for each course
            $sections = [
                [
                    'title' => 'Introduction & Overview',
                    'description' => 'Get started with the basics',
                    'order' => 1,
                ],
                [
                    'title' => 'Core Concepts',
                    'description' => 'Deep dive into main topics',
                    'order' => 2,
                ],
                [
                    'title' => 'Advanced Topics',
                    'description' => 'Explore advanced concepts',
                    'order' => 3,
                ],
            ];

            foreach ($sections as $sectionData) {
                $sectionData['course_id'] = $course->id;
                $section = CourseSection::create($sectionData);

                // Create lectures for each section
                $lectureCount = rand(3, 6);
                for ($i = 1; $i <= $lectureCount; $i++) {
                    CourseLecture::create([
                        'section_id' => $section->id,
                        'title' => "{$section->title} - Lecture {$i}",
                        'type' => ['video', 'pdf', 'quiz'][rand(0, 2)],
                        'duration' => rand(600, 3600),
                        'is_preview' => $i === 1,
                        'order' => $i,
                        'description' => "Learn about {$section->title} in this lecture.",
                    ]);
                }
            }
        }

        echo "Course seeding completed successfully!\n";
    }
}
