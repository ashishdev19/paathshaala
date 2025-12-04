<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AssignInstructorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User email to assign role to
        $userEmail = 'professor@paathshaala.com';

        // 1. Find the user
        $user = User::where('email', $userEmail)->first();

        if (!$user) {
            $this->command->error("User with email '{$userEmail}' not found.");
            return;
        }

        $this->command->info("Found user: {$user->name} ({$user->email})");

        // 2. Get or create the Instructor role
        $role = $this->getOrCreateInstructorRole();

        // 3. Check if user already has the role
        if ($user->role_id === $role->id) {
            $this->command->warn("User already has the '{$role->name}' role (ID: {$role->id}).");
            return;
        }

        // 4. Assign the role
        $user->update(['role_id' => $role->id]);

        // 5. Clear caches
        app()['cache']->forget('spatie.permission.cache');
        app()['cache']->flush();

        $this->command->info("✓ Successfully assigned '{$role->name}' role (ID: {$role->id}) to {$user->name}.");
        $this->command->info("✓ Application cache cleared.");
    }

    /**
     * Get or create the Instructor role.
     *
     * @return \App\Models\Role
     */
    private function getOrCreateInstructorRole()
    {
        $roleName = 'Instructor';
        $roleSlug = 'instructor';

        // Check if role exists
        $role = Role::where('slug', $roleSlug)->first();

        if ($role) {
            $this->command->info("Role '{$roleName}' already exists (ID: {$role->id}).");
            return $role;
        }

        // Create the role
        $role = Role::create([
            'name' => $roleName,
            'slug' => $roleSlug,
            'description' => 'Instructor/Teacher role with course management capabilities.',
        ]);

        $this->command->info("✓ Created new role: '{$roleName}' (ID: {$role->id})");

        return $role;
    }
}
