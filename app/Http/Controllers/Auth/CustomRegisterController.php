<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class CustomRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validationRules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'user_type' => ['required', 'in:instructor,student'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:10'],
        ];

        // Add profession type validation if user is instructor
        if ($request->user_type === 'instructor') {
            $validationRules['profession_type'] = ['required', 'string', 'max:100'];
        }

        $request->validate($validationRules);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'user_type' => $request->user_type,
                'profession_type' => $request->profession_type,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            // Assign role based on user_type
            if ($request->user_type === 'instructor') {
                $user->assignRole('instructor');
            } else {
                $user->assignRole('student');
            }

            // Login the user
            Auth::login($user);

            // Reload user to get fresh role data
            $user->refresh();

            // Redirect directly to role-specific dashboard
            if ($user->isInstructor()) {
                return redirect()->route('instructor.dashboard');
            } elseif ($user->isStudent()) {
                return redirect()->route('student.dashboard');
            }
            
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
        }
    }
}