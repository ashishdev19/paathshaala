<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfessorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Force refresh the role relationship from database to avoid lazy loading issues
        $user->load('role');
        
        // Log the authorization check for debugging
        \Log::info('ProfessorMiddleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'role_id' => $user->role_id,
            'role_slug' => $user->role?->slug,
            'isSuperAdmin' => $user->isSuperAdmin(),
            'isAdmin' => $user->isAdmin(),
            'isInstructor' => $user->isInstructor(),
            'route' => $request->getPathInfo(),
        ]);
        
        // Allow SuperAdmin, Admin, and Instructor (also accept 'teacher' for backward compatibility)
        $isAuthorized = $user->isSuperAdmin() || $user->isAdmin() || $user->isInstructor() || ($user->role?->slug === 'teacher');
        
        if (!$isAuthorized) {
            \Log::warning('ProfessorMiddleware: Access Denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'role_slug' => $user->role?->slug,
            ]);
            abort(403, 'You do not have permission to access instructor routes. Please login as an instructor or admin.');
        }

        return $next($request);
    }
}
