<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;
use Carbon\Carbon;

class NewStudentOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a 30% discount offer for new students
        Offer::create([
            'title' => 'New Student Welcome Discount',
            'description' => 'Get 30% off on any course as a new student! This exclusive offer is available for first-time enrollments only.',
            'code' => 'NEWSTUDENT30',
            'type' => 'percentage',
            'value' => 30.00,
            'minimum_amount' => 500.00, // Minimum course price of ₹500
            'usage_limit' => null, // Unlimited usage
            'used_count' => 0,
            'valid_from' => Carbon::now(),
            'valid_until' => Carbon::now()->addMonths(12), // Valid for 1 year
            'is_active' => true,
            'applicable_courses' => [], // Applies to all courses
        ]);

        // Create a special limited-time offer
        Offer::create([
            'title' => 'First Time Learner Special',
            'description' => 'Exclusive 25% discount for new users on premium courses. Limited time offer!',
            'code' => 'FIRSTTIME25',
            'type' => 'percentage',
            'value' => 25.00,
            'minimum_amount' => 1000.00, // For premium courses
            'usage_limit' => 500, // Limited to 500 uses
            'used_count' => 0,
            'valid_from' => Carbon::now(),
            'valid_until' => Carbon::now()->addDays(90), // Valid for 3 months
            'is_active' => true,
            'applicable_courses' => [], // Applies to all courses
        ]);

        // Create a fixed amount discount for budget-conscious students
        Offer::create([
            'title' => 'Student Budget Saver',
            'description' => 'Save ₹300 on any course! Perfect for students on a budget.',
            'code' => 'SAVE300',
            'type' => 'fixed_amount',
            'value' => 300.00,
            'minimum_amount' => 800.00, // Minimum course price
            'usage_limit' => null,
            'used_count' => 0,
            'valid_from' => Carbon::now(),
            'valid_until' => Carbon::now()->addMonths(6),
            'is_active' => true,
            'applicable_courses' => [],
        ]);
    }
}
