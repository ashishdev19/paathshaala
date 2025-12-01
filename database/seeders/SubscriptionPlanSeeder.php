<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Silver',
                'slug' => 'silver',
                'description' => 'Perfect for new teachers. Teach up to 5 courses and 100 students.',
                'price' => 5000.00,
                'features' => json_encode([
                    'Online class hosting',
                    'Up to 5 courses',
                    'Up to 100 students',
                    'Certificate generation',
                    'Email support',
                    'Basic analytics',
                ]),
                'max_students' => 100,
                'max_courses' => 5,
                'is_active' => true,
                'priority' => 3,
            ],
            [
                'name' => 'Gold',
                'slug' => 'gold',
                'description' => 'For growing teachers. Teach up to 20 courses and 500 students.',
                'price' => 10000.00,
                'features' => json_encode([
                    'Online class hosting',
                    'Up to 20 courses',
                    'Up to 500 students',
                    'Certificate generation',
                    'Priority email support',
                    'Advanced analytics',
                    'Custom course branding',
                    'Video recording & playback',
                    'Student progress tracking',
                ]),
                'max_students' => 500,
                'max_courses' => 20,
                'is_active' => true,
                'priority' => 2,
            ],
            [
                'name' => 'Platinum',
                'slug' => 'platinum',
                'description' => 'For professional teachers. Unlimited courses and 2000+ students.',
                'price' => 20000.00,
                'features' => json_encode([
                    'Online class hosting',
                    'Unlimited courses',
                    'Up to 2000 students',
                    'Certificate generation',
                    '24/7 priority support',
                    'Advanced analytics & reporting',
                    'Custom course branding',
                    'Video recording & playback',
                    'Advanced student tracking',
                    'Dedicated account manager',
                    'API access',
                    'White-label options',
                    'Team collaboration tools',
                    'Revenue sharing option',
                ]),
                'max_students' => 2000,
                'max_courses' => 999,
                'is_active' => true,
                'priority' => 1,
            ],
        ];

        foreach ($plans as $plan) {
            SubscriptionPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
