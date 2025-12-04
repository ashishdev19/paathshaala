<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRole;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class AccessControlController extends Controller
{
    /**
     * Display the unified access control management interface.
     */
    public function index()
    {
        $roles = AdminRole::withCount(['accounts', 'permissions'])
            ->orderBy('name')
            ->get();

        $permissions = AdminPermission::with('roles')
            ->orderBy('module')
            ->orderBy('name')
            ->get()
            ->groupBy('module');

        $allPermissions = AdminPermission::all();

        return view('admin.access-control.index', compact('roles', 'permissions', 'allPermissions'));
    }
}
