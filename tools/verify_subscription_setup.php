<?php

// Test file to verify subscription plans are in database
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';

$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\SubscriptionPlan;

echo "=== Checking Subscription Plans ===\n\n";

$plans = SubscriptionPlan::orderBy('priority')->get();

if ($plans->isEmpty()) {
    echo "❌ No subscription plans found in database!\n";
    echo "Run: php artisan db:seed --class=SubscriptionPlanSeeder\n";
} else {
    echo "✅ Found " . $plans->count() . " subscription plans:\n\n";
    
    foreach ($plans as $plan) {
        echo "Plan: {$plan->name}\n";
        echo "  - Slug: {$plan->slug}\n";
        echo "  - Price: ₹{$plan->price}/year\n";
        echo "  - Max Students: {$plan->max_students}\n";
        echo "  - Max Courses: {$plan->max_courses}\n";
        echo "  - Status: " . ($plan->is_active ? 'Active' : 'Inactive') . "\n";
        echo "  - Priority: {$plan->priority}\n";
        echo "  - Features: " . count($plan->features_list) . " features\n";
        echo "    - " . implode("\n    - ", $plan->features_list) . "\n\n";
    }
}

echo "\n=== Checking Database Tables ===\n\n";

$tables = [
    'subscription_plans',
    'teacher_enquiries',
    'teacher_subscriptions',
    'teacher_subscription_history',
];

$schema = \Illuminate\Support\Facades\Schema::class;

foreach ($tables as $table) {
    $exists = \Illuminate\Support\Facades\Schema::hasTable($table);
    echo ($exists ? "✅" : "❌") . " Table: {$table}\n";
}

echo "\nSetup complete!\n";
