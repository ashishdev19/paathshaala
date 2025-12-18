<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
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
        
        \Log::info('StudentMiddleware Check', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'roles' => $user->getRoleNames(),
            'isStudent' => $user->isStudent(),
        ]);
        
        // Allow all authenticated users to access student routes
        if (!$user->isStudent() && !$user->isInstructor() && !$user->isAdmin() && !$user->isSuperAdmin()) {
            \Log::warning('StudentMiddleware: Access Denied', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'roles' => $user->getRoleNames(),
            ]);
            abort(403, 'Access denied. You do not have the required role.');
        }

        return $next($request);
    }
}
