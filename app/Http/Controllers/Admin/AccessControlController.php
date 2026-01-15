<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class AccessControlController extends Controller
{
    /**
     * Display the unified access control management interface.
     */
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])
            ->orderBy('name')
            ->get();

        $permissions = Permission::with('roles')
            ->orderBy('name')
            ->get()
            ->groupBy(function ($permission) {
                // Group permissions by their prefix (e.g., "admin.", "teacher.", "student.")
                $parts = explode('.', $permission->name);
                return count($parts) > 1 ? $parts[0] : 'general';
            });

        $allPermissions = Permission::all();

        return view('admin.access-control.index', compact('roles', 'permissions', 'allPermissions'));
    }
}
