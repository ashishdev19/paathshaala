<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

echo "\n=== PERMISSIONS TABLE ===\n";
$permissions = Permission::all();
echo "Total Permissions: " . count($permissions) . "\n\n";

foreach ($permissions as $p) {
    echo $p->id . ". " . $p->name . " (guard: " . $p->guard_name . ")\n";
}

echo "\n=== ROLES TABLE ===\n";
$roles = Role::all();
echo "Total Roles: " . count($roles) . "\n\n";

foreach ($roles as $r) {
    echo $r->id . ". " . $r->name . " - Permissions: " . $r->permissions->count() . "\n";
}
