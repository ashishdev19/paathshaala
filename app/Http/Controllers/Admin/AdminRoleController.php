<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Admin Role Controller - Uses Spatie Permission Package
 * 
 * This controller manages roles using Spatie's Role model exclusively.
 * All role operations use hasRole(), hasAnyRole(), and can() methods.
 */
class AdminRoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->withCount('users')
            ->latest()
            ->paginate(15);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role
     */
    public function create()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            // Group by first part of permission name (e.g., 'view-dashboard' -> 'view')
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Create role with web guard (default)
        $role = Role::create([
            'name' => Str::slug($validated['name']),
            'guard_name' => 'web',
        ]);

        // Sync permissions using Spatie's method
        if ($request->has('permissions') && !empty($request->permissions)) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role created successfully!');
    }

    /**
     * Show the form for editing the specified role
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'general';
        });
        
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Update role name
        $role->update([
            'name' => Str::slug($validated['name']),
        ]);

        // Sync permissions using Spatie's method
        if ($request->has('permissions') && !empty($request->permissions)) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role)
    {
        // Prevent deleting core roles
        $protectedRoles = ['superadmin', 'admin', 'instructor', 'student'];
        
        if (in_array($role->name, $protectedRoles)) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Cannot delete protected system role.');
        }

        // Check if role has users assigned
        if ($role->users()->count() > 0) {
            return redirect()
                ->route('admin.roles.index')
                ->with('error', 'Cannot delete role with assigned users. Please reassign users first.');
        }

        // Revoke all permissions and delete role
        $role->syncPermissions([]);
        $role->delete();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Role deleted successfully!');
    }
}
