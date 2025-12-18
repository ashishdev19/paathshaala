<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ==========================================
        // CREATE ROLES
        // ==========================================
        
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $instructorRole = Role::firstOrCreate(['name' => 'instructor']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // ==========================================
        // CREATE PERMISSIONS
        // ==========================================

        $permissions = [
            // Super Admin Permissions (All)
            'view-dashboard',
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'manage-courses',
            'manage-payments',
            'manage-settings',
            'view-analytics',
            'manage-admins',

            // Admin Permissions
            'view-admin-dashboard',
            'manage-content',
            'manage-instructors',
            'manage-students',
            'view-reports',

            // Instructor Permissions
            'create-courses',
            'edit-own-courses',
            'delete-own-courses',
            'manage-live-classes',
            'view-enrollments',
            'access-wallet',

            // Student Permissions
            'view-courses',
            'enroll-courses',
            'access-content',
            'submit-reviews',
            'view-certificates',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ==========================================
        // ASSIGN PERMISSIONS TO ROLES
        // ==========================================

        // Super Admin - All permissions
        $superadminRole->givePermissionTo(Permission::all());

        // Admin - Limited permissions
        $adminRole->givePermissionTo([
            'view-admin-dashboard',
            'manage-content',
            'manage-instructors',
            'manage-students',
            'manage-payments',
            'view-reports',
        ]);

        // Instructor - Course and class management
        $instructorRole->givePermissionTo([
            'create-courses',
            'edit-own-courses',
            'delete-own-courses',
            'manage-live-classes',
            'view-enrollments',
            'access-wallet',
        ]);

        // Student - Course access and enrollment
        $studentRole->givePermissionTo([
            'view-courses',
            'enroll-courses',
            'access-content',
            'submit-reviews',
            'view-certificates',
        ]);

        // ==========================================
        // CREATE TEST USERS
        // ==========================================

        $superadminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $superadminUser->assignRole('superadmin');

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $adminUser->assignRole('admin');

        $instructorUser = User::firstOrCreate(
            ['email' => 'instructor@example.com'],
            [
                'name' => 'Test Instructor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $instructorUser->assignRole('instructor');

        $studentUser = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $studentUser->assignRole('student');

        $this->command->info('✅ Roles created successfully!');
        $this->command->info('✅ Permissions created and assigned!');
        $this->command->info('');
        $this->command->info('📝 TEST USERS CREATED:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('Super Admin | Email: superadmin@example.com | Password: password');
        $this->command->info('Admin       | Email: admin@example.com       | Password: password');
        $this->command->info('Instructor  | Email: instructor@example.com  | Password: password');
        $this->command->info('Student     | Email: student@example.com     | Password: password');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}

