<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Log the attempt for debugging
        Log::info('Login attempt for email: ' . $request->email);
        
        $request->authenticate();

        $request->session()->regenerate();

        // Get the authenticated user and redirect based on role
        $user = Auth::user();
        
        Log::info('User authenticated: ' . $user->email . ', Role: ' . $user->getRoleNames());
        
        if ($user->hasRole('admin')) {
            Log::info('Redirecting to admin dashboard');
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            Log::info('Redirecting to teacher dashboard');
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('student')) {
            Log::info('Redirecting to student dashboard');
            return redirect()->route('student.dashboard');
        }
        
        // Fallback to general dashboard
        Log::info('Redirecting to general dashboard');
        return redirect()->route('dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
