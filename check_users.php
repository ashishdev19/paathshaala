<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

$users = \App\Models\User::with('role')->get(['id', 'name', 'email', 'role_id']);

echo "Current Users in Database:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
foreach ($users as $user) {
    $roleSlug = $user->role?->slug ?? 'NO ROLE';
    echo "{$user->name} | {$user->email} | Role: {$roleSlug}\n";
}
