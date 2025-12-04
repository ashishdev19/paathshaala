<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

// Check all users and their roles
echo "All Users in Database with Roles:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$users = \App\Models\User::with('role')->get();
foreach ($users as $user) {
    $role = $user->role?->slug ?? 'NULL';
    $isInstructor = $user->isInstructor() ? '✅' : '❌';
    echo "{$user->name} ({$user->email}) | Role: {$role} | isInstructor: {$isInstructor}\n";
}

echo "\n\nRole Records in Database:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$roles = \App\Models\Role::all();
foreach ($roles as $role) {
    echo "ID: {$role->id} | Slug: {$role->slug} | Name: {$role->name}\n";
}
