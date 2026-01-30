<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ReferralCode;
use App\Services\ReferralService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'role' => ['required', 'string', 'in:student,teacher'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['nullable', 'string', 'max:20'],
        ]);

        // Check if referral code is valid
        $referralCodeModel = null;
        if ($request->filled('referral_code')) {
            \Log::info('Referral code provided during registration', [
                'code' => $request->referral_code,
                'email' => $request->email
            ]);
            
            $referralCodeModel = ReferralCode::where('code', $request->referral_code)
                ->where('is_active', true)
                ->first();
            
            if (!$referralCodeModel) {
                \Log::warning('Invalid referral code provided', [
                    'code' => $request->referral_code
                ]);
                return back()->withErrors([
                    'referral_code' => 'Invalid or inactive referral code.'
                ])->withInput();
            }
            
            \Log::info('Valid referral code found', [
                'code' => $request->referral_code,
                'owner_id' => $referralCodeModel->user_id
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        // Assign role to user
        $user->assignRole($request->role);

        // Create referral code for the new user
        ReferralCode::createForUser($user);

        // Process referral if code was provided
        if ($referralCodeModel) {
            \Log::info('Processing referral signup', [
                'new_user_id' => $user->id,
                'referral_code' => $request->referral_code,
                'referrer_id' => $referralCodeModel->user_id
            ]);
            
            $referralService = app(ReferralService::class);
            $referralResult = $referralService->processReferralSignup($user, $request->referral_code);
            
            if ($referralResult) {
                \Log::info('Referral signup processed successfully', [
                    'referral_id' => $referralResult->id,
                    'referred_discount' => $referralResult->referred_discount
                ]);
            } else {
                \Log::warning('Referral signup failed - no referral created');
            }
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
