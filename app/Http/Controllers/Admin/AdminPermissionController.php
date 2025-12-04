<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminPermission;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPermissionController extends Controller
{
    /**
     * Display a listing of permissions
     */
    public function index()
    {
        $permissions = AdminPermission::orderBy('module')->orderBy('name')->get()->groupBy('module');
        $roles = AdminRole::with('permissions')->get();

        return view('admin.permissions.index', compact('permissions', 'roles'));
    }

    /**
     * Show the form for creating a new permission
     */
    public function create()
    {
        $modules = AdminPermission::distinct()->pluck('module')->filter();
        return view('admin.permissions.create', compact('modules'));
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admin_permissions,name',
            'description' => 'nullable|string|max:500',
            'module' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        AdminPermission::create($validated);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission created successfully!');
    }

    /**
     * Show the form for assigning permissions to roles
     */
    public function assign()
    {
        $roles = AdminRole::with('permissions')->get();
        $permissions = AdminPermission::orderBy('module')->orderBy('name')->get()->groupBy('module');

        return view('admin.permissions.assign', compact('roles', 'permissions'));
    }

    /**
     * Assign permissions to a role
     */
    public function assignStore(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:admin_roles,id',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:admin_permissions,id',
        ]);

        $role = AdminRole::findOrFail($validated['role_id']);
        $role->permissions()->sync($request->permissions ?? []);

        return redirect()
            ->route('admin.permissions.assign')
            ->with('success', 'Permissions assigned successfully to ' . $role->name . '!');
    }

    /**
     * Remove the specified permission
     */
    public function destroy(AdminPermission $permission)
    {
        // Detach from all roles
        $permission->roles()->detach();
        $permission->delete();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully!');
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, AdminPermission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admin_permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:500',
            'module' => 'nullable|string|max:100',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $permission->update($validated);

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully!');
    }
}
