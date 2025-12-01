<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ==========================================
        // CREATE ROLES
        // ==========================================
        
        $superadminRole = Role::firstOrCreate(
            ['slug' => 'superadmin'],
            [
                'name' => 'Super Admin',
                'description' => 'Full system access - Complete control over the platform',
            ]
        );

        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'Admin access to manage platform, users, courses, payments',
            ]
        );

        $instructorRole = Role::firstOrCreate(
            ['slug' => 'instructor'],
            [
                'name' => 'Instructor',
                'description' => 'Can create and manage own courses and classes',
            ]
        );

        $studentRole = Role::firstOrCreate(
            ['slug' => 'student'],
            [
                'name' => 'Student',
                'description' => 'Student access to enroll and view courses',
            ]
        );

        // ==========================================
        // CREATE PERMISSIONS
        // ==========================================

        $permissions = [
            // Super Admin Permissions (All)
            'view-dashboard' => 'View Dashboard',
            'manage-users' => 'Manage Users',
            'manage-roles' => 'Manage Roles',
            'manage-permissions' => 'Manage Permissions',
            'manage-courses' => 'Manage All Courses',
            'manage-payments' => 'Manage Payments',
            'manage-settings' => 'Manage Settings',
            'view-analytics' => 'View Analytics',
            'manage-admins' => 'Manage Admins',

            // Admin Permissions
            'view-admin-dashboard' => 'View Admin Dashboard',
            'manage-content' => 'Manage Content',
            'manage-instructors' => 'Manage Instructors',
            'manage-students' => 'Manage Students',
            'view-reports' => 'View Reports',

            // Instructor Permissions
            'create-courses' => 'Create Courses',
            'edit-own-courses' => 'Edit Own Courses',
            'delete-own-courses' => 'Delete Own Courses',
            'manage-live-classes' => 'Manage Live Classes',
            'view-enrollments' => 'View Own Course Enrollments',
            'access-wallet' => 'Access Wallet',

            // Student Permissions
            'view-courses' => 'View Courses',
            'enroll-courses' => 'Enroll in Courses',
            'access-content' => 'Access Course Content',
            'submit-reviews' => 'Submit Reviews',
            'view-certificates' => 'View Certificates',
        ];

        foreach ($permissions as $slug => $name) {
            Permission::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'description' => $name]
            );
        }

        // ==========================================
        // ASSIGN PERMISSIONS TO ROLES
        // ==========================================

        // Super Admin - All permissions
        $superadminRole->permissions()->sync(Permission::pluck('id')->toArray());

        // Admin - Limited permissions
        $adminPermissions = Permission::whereIn('slug', [
            'view-admin-dashboard',
            'manage-content',
            'manage-instructors',
            'manage-students',
            'manage-payments',
            'view-reports',
        ])->pluck('id')->toArray();
        $adminRole->permissions()->sync($adminPermissions);

        // Instructor - Course and class management
        $instructorPermissions = Permission::whereIn('slug', [
            'create-courses',
            'edit-own-courses',
            'delete-own-courses',
            'manage-live-classes',
            'view-enrollments',
            'access-wallet',
        ])->pluck('id')->toArray();
        $instructorRole->permissions()->sync($instructorPermissions);

        // Student - Course access and enrollment
        $studentPermissions = Permission::whereIn('slug', [
            'view-courses',
            'enroll-courses',
            'access-content',
            'submit-reviews',
            'view-certificates',
        ])->pluck('id')->toArray();
        $studentRole->permissions()->sync($studentPermissions);

        // ==========================================
        // CREATE TEST USERS
        // ==========================================

        $superadminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $superadminRole->id,
            ]
        );

        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $adminRole->id,
            ]
        );

        $instructorUser = User::firstOrCreate(
            ['email' => 'instructor@example.com'],
            [
                'name' => 'Test Instructor',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $instructorRole->id,
            ]
        );

        $studentUser = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $studentRole->id,
            ]
        );

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

