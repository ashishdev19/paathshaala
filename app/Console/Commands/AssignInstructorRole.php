<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;

class AssignInstructorRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:instructor-role {email=professor@paathshaala.com : The email of the user to assign the Instructor role}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Assigns the Instructor role to a user. Creates the role if it does not exist. Safe and idempotent.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        // 1. Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return Command::FAILURE;
        }

        $this->info("Found user: {$user->name} ({$user->email})");

        // 2. Get or create the Instructor role
        $role = $this->getOrCreateInstructorRole();

        // 3. Check if user already has the role
        if ($user->role_id === $role->id) {
            $this->warn("User already has the '{$role->name}' role (ID: {$role->id}).");
            return Command::SUCCESS;
        }

        // 4. Assign the role to the user
        $user->update(['role_id' => $role->id]);

        // 5. Clear caches
        app()['cache']->forget('spatie.permission.cache');
        app()['cache']->flush();

        $this->info("✓ Successfully assigned '{$role->name}' role (ID: {$role->id}) to {$user->name}.");
        $this->info("✓ Application cache cleared.");

        return Command::SUCCESS;
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
            $this->info("Role '{$roleName}' already exists (ID: {$role->id}).");
            return $role;
        }

        // Create the role
        $role = Role::create([
            'name' => $roleName,
            'slug' => $roleSlug,
            'description' => 'Instructor/Teacher role with course management capabilities.',
        ]);

        $this->info("✓ Created new role: '{$roleName}' (ID: {$role->id})");

        return $role;
    }
}
