<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccount;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of admin accounts
     */
    public function index()
    {
        $accounts = AdminAccount::with('role')
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => AdminAccount::count(),
            'active' => AdminAccount::where('is_active', true)->count(),
            'inactive' => AdminAccount::where('is_active', false)->count(),
        ];

        return view('admin.accounts.index', compact('accounts', 'stats'));
    }

    /**
     * Show the form for creating a new admin account
     */
    public function create()
    {
        $roles = AdminRole::active()->get();
        return view('admin.accounts.create', compact('roles'));
    }

    /**
     * Store a newly created admin account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_accounts,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'admin_role_id' => 'required|exists:admin_roles,id',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['email_verified_at'] = now();

        $account = AdminAccount::create($validated);

        return redirect()
            ->route('admin.accounts.index')
            ->with('success', 'Admin account created successfully! Login credentials have been set.');
    }

    /**
     * Display the specified admin account
     */
    public function show(AdminAccount $account)
    {
        $account->load('role.permissions');
        return view('admin.accounts.show', compact('account'));
    }

    /**
     * Show the form for editing the specified admin account
     */
    public function edit(AdminAccount $account)
    {
        $roles = AdminRole::active()->get();
        return view('admin.accounts.edit', compact('account', 'roles'));
    }

    /**
     * Update the specified admin account
     */
    public function update(Request $request, AdminAccount $account)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admin_accounts,email,' . $account->id,
            'password' => ['nullable', 'confirmed', Password::min(8)->letters()->numbers()],
            'admin_role_id' => 'required|exists:admin_roles,id',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        // Only update password if provided
        if (!$request->filled('password')) {
            unset($validated['password']);
        }

        $account->update($validated);

        return redirect()
            ->route('admin.accounts.index')
            ->with('success', 'Admin account updated successfully!');
    }

    /**
     * Remove the specified admin account
     */
    public function destroy(AdminAccount $account)
    {
        // Prevent deleting own account
        if (auth()->guard('admin')->check() && auth()->guard('admin')->id() === $account->id) {
            return redirect()
                ->route('admin.accounts.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $account->delete();

        return redirect()
            ->route('admin.accounts.index')
            ->with('success', 'Admin account deleted successfully!');
    }

    /**
     * Toggle account active status
     */
    public function toggleStatus(AdminAccount $account)
    {
        $account->update(['is_active' => !$account->is_active]);

        $status = $account->is_active ? 'activated' : 'deactivated';
        
        return redirect()
            ->back()
            ->with('success', "Account {$status} successfully!");
    }
}
