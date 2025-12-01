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

        // Allow all authenticated users to access student routes
        if (!auth()->user()->isStudent() && !auth()->user()->isInstructor() && !auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'You do not have permission to access this resource. Only authenticated users can access.');
        }

        return $next($request);
    }
}
