<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

/**
 * Admin Account Controller - Uses Spatie Permission Package
 * 
 * This controller manages admin/superadmin users using Spatie roles.
 * Instead of separate AdminAccount model, we use User model with admin/superadmin roles.
 */
class AdminAccountController extends Controller
{
    /**
     * Display a listing of admin users (users with admin or superadmin role)
     */
    public function index()
    {
        $accounts = User::role(['admin', 'superadmin'])
            ->with('roles')
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => User::role(['admin', 'superadmin'])->count(),
            'superadmins' => User::role('superadmin')->count(),
            'admins' => User::role('admin')->count(),
        ];

        return view('admin.accounts.index', compact('accounts', 'stats'));
    }

    /**
     * Show the form for creating a new admin user
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'superadmin'])->get();
        return view('admin.accounts.create', compact('roles'));
    }

    /**
     * Store a newly created admin user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'role' => 'required|in:admin,superadmin',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'email_verified_at' => now(),
        ]);

        // Assign Spatie role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('admin.accounts.index')
            ->with('success', 'Admin account created successfully!');
    }

    /**
     * Display the specified admin user
     */
    public function show(User $account)
    {
        // Ensure user has admin role
        if (!$account->hasAnyRole(['admin', 'superadmin'])) {
            abort(404);
        }
        
        $account->load('roles.permissions');
        return view('admin.accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified admin user
     */
    public function edit(User $account)
    {
        if (!$account->hasAnyRole(['admin', 'superadmin'])) {
            abort(404);
        }
        
        $roles = Role::whereIn('name', ['admin', 'superadmin'])->get();
        return view('admin.accounts.edit', compact('account', 'roles'));
    }

    /**
     * Update the specified admin user
     */
    public function update(Request $request, User $account)
    {
        if (!$account->hasAnyRole(['admin', 'superadmin'])) {
            abort(404);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $account->id,
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
            'role' => 'required|in:admin,superadmin',
            'phone' => 'nullable|string|max:20',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $account->update($updateData);

        // Sync role using Spatie
        $account->syncRoles([$validated['role']]);

        return redirect()
            ->route('admin.accounts.index')
            ->with('success', 'Admin account updated successfully!');
    }

    /**
     * Remove the specified admin user
     */
    public function destroy(User $account)
    {
        if (!$account->hasAnyRole(['admin', 'superadmin'])) {
            abort(404);
        }
        
        // Prevent deleting own account
        if (auth()->id() === $account->id) {
            return redirect()
                ->route('admin.accounts.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Remove roles before deleting
        $account->syncRoles([]);
        $account->delete();

        return redirect()
            ->route('admin.accounts.index')
            ->with('success', 'Admin account deleted successfully!');
    }

    /**
     * Toggle account active status (using email_verified_at as proxy)
     */
    public function toggleStatus(User $account)
    {
        if (!$account->hasAnyRole(['admin', 'superadmin'])) {
            abort(404);
        }
        
        // Toggle verified status as active/inactive proxy
        if ($account->email_verified_at) {
            $account->update(['email_verified_at' => null]);
            $status = 'deactivated';
        } else {
            $account->update(['email_verified_at' => now()]);
            $status = 'activated';
        }
        
        return redirect()
            ->back()
            ->with('success', "Account {$status} successfully!");
    }
}
