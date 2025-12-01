<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class UpdateCoursesValiditySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing courses with different validity periods
        $courses = Course::all();
        
        foreach ($courses as $index => $course) {
            // Vary validity based on course price and category
            if ($course->price >= 5000) {
                // High-priced courses get lifetime access
                $course->update([
                    'is_lifetime' => true,
                    'validity_days' => 365 // Default, but won't be used since is_lifetime is true
                ]);
            } elseif ($course->price >= 3000) {
                // Medium-priced courses get 1 year access
                $course->update([
                    'is_lifetime' => false,
                    'validity_days' => 365
                ]);
            } elseif ($course->price >= 1500) {
                // Lower-priced courses get 6 months access
                $course->update([
                    'is_lifetime' => false,
                    'validity_days' => 180
                ]);
            } else {
                // Cheap courses get 3 months access
                $course->update([
                    'is_lifetime' => false,
                    'validity_days' => 90
                ]);
            }
        }
        
        // Also create some specific examples for testing
        Course::where('title', 'like', '%Java%')->update([
            'is_lifetime' => false,
            'validity_days' => 30 // 1 month for testing expiry
        ]);
        
        Course::where('title', 'like', '%Advanced%')->update([
            'is_lifetime' => true,
            'validity_days' => 365
        ]);
    }
}
