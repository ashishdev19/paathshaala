<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\OnlineClass;
use App\Models\Course;
use App\Policies\OnlineClassPolicy;
use App\Policies\CoursePolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(OnlineClass::class, OnlineClassPolicy::class);
        Gate::policy(Course::class, CoursePolicy::class);
    }
}
