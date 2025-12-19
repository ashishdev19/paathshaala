<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstructorMiddleware
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
        
        // Log the authorization check for debugging
        \Log::info('InstructorMiddleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_name' => $user->name,
            'roles' => $user->getRoleNames(),
            'isSuperAdmin' => $user->isSuperAdmin(),
            'isAdmin' => $user->isAdmin(),
            'isInstructor' => $user->isInstructor(),
            'route' => $request->getPathInfo(),
        ]);
        
        // Allow SuperAdmin, Admin, and Instructor
        $isAuthorized = $user->isSuperAdmin() || $user->isAdmin() || $user->isInstructor();
        
        if (!$isAuthorized) {
            \Log::warning('InstructorMiddleware: Access Denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'roles' => $user->getRoleNames(),
            ]);
            abort(403, 'You do not have permission to access instructor routes. Please login as an instructor or admin.');
        }

        return $next($request);
    }
}
