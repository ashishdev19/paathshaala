<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OnlineClass;
use App\Models\Course;
use Carbon\Carbon;

class OnlineClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create past classes (recorded)
            OnlineClass::create([
                'course_id' => $course->id,
                'title' => 'Introduction Session - ' . $course->title,
                'description' => 'Welcome session covering course overview and expectations.',
                'type' => 'recorded',
                'video_url' => 'https://example.com/recordings/intro-' . $course->id,
                'scheduled_at' => Carbon::now()->subDays(7),
                'duration_minutes' => 60,
                'is_active' => true,
                'order' => 1,
            ]);

            OnlineClass::create([
                'course_id' => $course->id,
                'title' => 'Module 1 - Fundamentals',
                'description' => 'Deep dive into the fundamental concepts.',
                'type' => 'recorded',
                'video_url' => 'https://example.com/recordings/module1-' . $course->id,
                'scheduled_at' => Carbon::now()->subDays(5),
                'duration_minutes' => 90,
                'is_active' => true,
                'order' => 2,
            ]);

            // Create upcoming classes (live)
            OnlineClass::create([
                'course_id' => $course->id,
                'title' => 'Live Q&A Session',
                'description' => 'Interactive session to answer student questions.',
                'type' => 'live',
                'meeting_link' => 'https://zoom.us/j/123456789',
                'meeting_id' => '123456789',
                'meeting_password' => 'password123',
                'scheduled_at' => Carbon::now()->addDays(2)->setHour(14)->setMinute(0),
                'duration_minutes' => 60,
                'is_active' => true,
                'order' => 3,
            ]);

            OnlineClass::create([
                'course_id' => $course->id,
                'title' => 'Practical Workshop',
                'description' => 'Hands-on practice session with real-world scenarios.',
                'type' => 'live',
                'meeting_link' => 'https://zoom.us/j/987654321',
                'meeting_id' => '987654321',
                'meeting_password' => 'workshop123',
                'scheduled_at' => Carbon::now()->addDays(5)->setHour(10)->setMinute(0),
                'duration_minutes' => 120,
                'is_active' => true,
                'order' => 4,
            ]);
        }
    }
}
