<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);
        
        $middleware->alias([
            // Custom role middleware (uses Spatie hasRole internally)
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'course.access' => \App\Http\Middleware\CheckCourseAccess::class,
            'superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'instructor' => \App\Http\Middleware\InstructorMiddleware::class,
            'student' => \App\Http\Middleware\StudentMiddleware::class,
            
            // Spatie Permission Middleware (official)
            'spatie.role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'spatie.permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'spatie.role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
