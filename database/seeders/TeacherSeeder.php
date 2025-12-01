<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Teacher;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Dr. Esther Howard',
                'description' => 'Experienced medical professional with 10+ years in cardiology and patient care.',
                'price' => 25.00,
                // 'country_flag' => '🇺🇸',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Brooklyn Simons',
                'description' => 'Specialist in neurological sciences with extensive research background.',
                'price' => 34.00,
                // 'country_flag' => '🇫🇷',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Savannah Nguyen',
                'description' => 'Pediatric medicine expert with focus on child development and care.',
                'price' => 48.00,
                // 'country_flag' => '🇯🇵',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Annette Black',
                'description' => 'Orthopedic surgeon specializing in sports medicine and rehabilitation.',
                'price' => 18.00,
                // 'country_flag' => '🇵🇱',
                'is_active' => true,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }
    }
}
