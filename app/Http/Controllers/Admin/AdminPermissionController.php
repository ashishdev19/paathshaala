<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Admin Permission Controller - Uses Spatie Permission Package
 * 
 * This controller manages permissions using Spatie's Permission model exclusively.
 */
class AdminPermissionController extends Controller
{
    /**
     * Display a listing of permissions
     */
    public function index()
    {
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'general';
        });
        $roles = Role::with('permissions')->get();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        $modules = Permission::all()->map(function ($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'general';
        })->unique()->filter();
        
        return view('admin.permissions.create', compact('modules'));
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        Permission::create([
            'name' => Str::slug($validated['name']),
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission created successfully!');
    }

    /**
     * Show the form for assigning permissions to roles
     */
    public function assign()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($permission) {
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'general';
        });

        return view('admin.permissions.assign', compact('roles', 'permissions'));
    }

    /**
     * Assign permissions to a role
     */
    public function assignStore(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($validated['role_id']);
        
        // Use Spatie's syncPermissions method
        if (!empty($request->permissions)) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name');
            $role->syncPermissions($permissionNames);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()
            ->route('admin.permissions.assign')
            ->with('success', 'Permissions assigned successfully to ' . $role->name . '!');
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Permission $permission)
    {
        // Revoke from all roles using Spatie
        $roles = Role::all();
        foreach ($roles as $role) {
            if ($role->hasPermissionTo($permission->name)) {
                $role->revokePermissionTo($permission->name);
            }
        }
        
        $permission->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully!');
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => Str::slug($validated['name']),
        ]);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully!');
    }
}
