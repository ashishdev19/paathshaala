<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = User::role('student')->first();
        $courses = Course::all();

        if ($student && $courses->count() > 0) {
            // Enroll student in first two courses
            foreach ($courses->take(2) as $course) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'enrolled_at' => Carbon::now()->subDays(rand(1, 10)),
                    'status' => 'active',
                    'progress_percentage' => rand(10, 80),
                ]);
            }

            // Create additional students for testing
            for ($i = 1; $i <= 5; $i++) {
                $testStudent = User::create([
                    'name' => "Test Student $i",
                    'email' => "teststudent$i@paathshaala.com",
                    'password' => bcrypt('password'),
                    'phone' => "+91 98765432$i$i",
                    'address' => "Test Address $i",
                    'email_verified_at' => now(),
                ]);
                
                $testStudent->assignRole('student');

                // Enroll in random courses
                $randomCourses = $courses->random(rand(1, 3));
                foreach ($randomCourses as $course) {
                    Enrollment::create([
                        'student_id' => $testStudent->id,
                        'course_id' => $course->id,
                        'enrolled_at' => Carbon::now()->subDays(rand(1, 30)),
                        'status' => collect(['active', 'completed'])->random(),
                        'progress_percentage' => rand(0, 100),
                    ]);
                }
            }
        }
    }
}
