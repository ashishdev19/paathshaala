<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\AdminPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = AdminRole::withCount(['accounts', 'permissions'])
            ->latest()
            ->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $permissions = AdminPermission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:admin_permissions,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $role = AdminRole::create($validated);

        // Attach permissions if provided
        if ($request->has('permissions')) {
            $role->permissions()->attach($request->permissions);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(AdminRole $role)
    {
        $permissions = AdminPermission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, AdminRole $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admin_roles,name,' . $role->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:admin_permissions,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        $role->update($validated);

        // Sync permissions
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role
     */
    public function destroy(AdminRole $role)
    {
        // Check if role has accounts
        if ($role->accounts()->count() > 0) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Cannot delete role with assigned accounts. Please reassign accounts first.');
        }

        $role->permissions()->detach();
        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role deleted successfully!');
    }
}
