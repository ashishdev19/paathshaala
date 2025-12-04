<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
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
        
        // Force refresh the role relationship from database
        $user->load('role');
        
        // Allow both SuperAdmin and Admin
        if (!$user->isAdmin() && !$user->isSuperAdmin()) {
            abort(403, 'You do not have permission to access this resource. Only Admins and Super Admins can access.');
        }

        return $next($request);
    }
}
