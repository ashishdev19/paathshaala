<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        // Create permissions
        $permissions = [
            // Admin permissions
            'manage-users',
            'manage-courses',
            'manage-payments',
            'manage-certificates',
            'manage-offers',
            'view-analytics',
            
            // Teacher permissions
            'create-courses',
            'manage-own-courses',
            'manage-classes',
            'view-students',
            
            // Student permissions
            'enroll-courses',
            'access-classes',
            'submit-reviews',
            'view-certificates',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        
        $teacherRole->givePermissionTo([
            'create-courses',
            'manage-own-courses',
            'manage-classes',
            'view-students',
        ]);
        
        $studentRole->givePermissionTo([
            'enroll-courses',
            'access-classes',
            'submit-reviews',
            'view-certificates',
        ]);
    }
}
