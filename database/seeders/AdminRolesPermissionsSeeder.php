<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminRole;
use App\Models\AdminPermission;
use Illuminate\Support\Str;

class AdminRolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions grouped by module
        $permissions = [
            // User Management
            'users' => [
                ['name' => 'View Users', 'slug' => 'view-users', 'description' => 'Can view list of users'],
                ['name' => 'Create Users', 'slug' => 'create-users', 'description' => 'Can create new users'],
                ['name' => 'Edit Users', 'slug' => 'edit-users', 'description' => 'Can edit existing users'],
                ['name' => 'Delete Users', 'slug' => 'delete-users', 'description' => 'Can delete users'],
                ['name' => 'Ban/Unban Users', 'slug' => 'ban-users', 'description' => 'Can ban or unban users'],
            ],
            
            // Course Management
            'courses' => [
                ['name' => 'View Courses', 'slug' => 'view-courses', 'description' => 'Can view all courses'],
                ['name' => 'Create Courses', 'slug' => 'create-courses', 'description' => 'Can create new courses'],
                ['name' => 'Edit Courses', 'slug' => 'edit-courses', 'description' => 'Can edit course details'],
                ['name' => 'Delete Courses', 'slug' => 'delete-courses', 'description' => 'Can delete courses'],
                ['name' => 'Approve Courses', 'slug' => 'approve-courses', 'description' => 'Can approve/reject course submissions'],
                ['name' => 'Publish Courses', 'slug' => 'publish-courses', 'description' => 'Can publish or unpublish courses'],
            ],
            
            // Enrollment Management
            'enrollments' => [
                ['name' => 'View Enrollments', 'slug' => 'view-enrollments', 'description' => 'Can view enrollment records'],
                ['name' => 'Manage Enrollments', 'slug' => 'manage-enrollments', 'description' => 'Can enroll/unenroll students'],
                ['name' => 'Cancel Enrollments', 'slug' => 'cancel-enrollments', 'description' => 'Can cancel enrollments'],
            ],
            
            // Payment & Financial Management
            'payments' => [
                ['name' => 'View Payments', 'slug' => 'view-payments', 'description' => 'Can view payment transactions'],
                ['name' => 'Process Refunds', 'slug' => 'process-refunds', 'description' => 'Can process refund requests'],
                ['name' => 'View Financial Reports', 'slug' => 'view-financial-reports', 'description' => 'Can view financial reports and analytics'],
                ['name' => 'Manage Pricing', 'slug' => 'manage-pricing', 'description' => 'Can update course pricing'],
                ['name' => 'View Revenue Analytics', 'slug' => 'view-revenue-analytics', 'description' => 'Can view revenue dashboards'],
            ],
            
            // Wallet Management
            'wallet' => [
                ['name' => 'View Wallets', 'slug' => 'view-wallets', 'description' => 'Can view user wallet balances'],
                ['name' => 'Manage Wallet Transactions', 'slug' => 'manage-wallet-transactions', 'description' => 'Can add/deduct wallet balance'],
                ['name' => 'View Wallet Reports', 'slug' => 'view-wallet-reports', 'description' => 'Can view wallet transaction reports'],
            ],
            
            // Subscription Management
            'subscriptions' => [
                ['name' => 'View Subscriptions', 'slug' => 'view-subscriptions', 'description' => 'Can view subscription plans and users'],
                ['name' => 'Manage Subscription Plans', 'slug' => 'manage-subscription-plans', 'description' => 'Can create/edit subscription plans'],
                ['name' => 'Cancel Subscriptions', 'slug' => 'cancel-subscriptions', 'description' => 'Can cancel user subscriptions'],
            ],
            
            // Certificate Management
            'certificates' => [
                ['name' => 'View Certificates', 'slug' => 'view-certificates', 'description' => 'Can view issued certificates'],
                ['name' => 'Issue Certificates', 'slug' => 'issue-certificates', 'description' => 'Can manually issue certificates'],
                ['name' => 'Revoke Certificates', 'slug' => 'revoke-certificates', 'description' => 'Can revoke certificates'],
            ],
            
            // Verification & Approval
            'verification' => [
                ['name' => 'Verify Instructors', 'slug' => 'verify-instructors', 'description' => 'Can verify instructor applications'],
                ['name' => 'Verify Student Documents', 'slug' => 'verify-student-documents', 'description' => 'Can verify student submitted documents'],
                ['name' => 'Approve Withdrawal Requests', 'slug' => 'approve-withdrawals', 'description' => 'Can approve withdrawal requests'],
            ],
            
            // Support & Communication
            'support' => [
                ['name' => 'View Support Tickets', 'slug' => 'view-support-tickets', 'description' => 'Can view support tickets'],
                ['name' => 'Respond to Tickets', 'slug' => 'respond-to-tickets', 'description' => 'Can respond to support tickets'],
                ['name' => 'Close Support Tickets', 'slug' => 'close-support-tickets', 'description' => 'Can close resolved tickets'],
                ['name' => 'Send Notifications', 'slug' => 'send-notifications', 'description' => 'Can send email/SMS notifications'],
            ],
            
            // Reports & Analytics
            'reports' => [
                ['name' => 'View Reports', 'slug' => 'view-reports', 'description' => 'Can view system reports'],
                ['name' => 'View Analytics Dashboard', 'slug' => 'view-analytics-dashboard', 'description' => 'Can access analytics dashboard'],
                ['name' => 'Export Reports', 'slug' => 'export-reports', 'description' => 'Can export reports to CSV/PDF'],
                ['name' => 'View User Activity Logs', 'slug' => 'view-activity-logs', 'description' => 'Can view user activity logs'],
            ],
            
            // Settings & Configuration
            'settings' => [
                ['name' => 'Manage Site Settings', 'slug' => 'manage-site-settings', 'description' => 'Can update site configuration'],
                ['name' => 'Manage Email Templates', 'slug' => 'manage-email-templates', 'description' => 'Can edit email templates'],
                ['name' => 'View System Logs', 'slug' => 'view-system-logs', 'description' => 'Can view system error logs'],
            ],
        ];

        // Create permissions
        $createdPermissions = [];
        foreach ($permissions as $module => $modulePermissions) {
            foreach ($modulePermissions as $permission) {
                $createdPermissions[$permission['slug']] = AdminPermission::create([
                    'name' => $permission['name'],
                    'slug' => $permission['slug'],
                    'description' => $permission['description'],
                    'module' => $module,
                ]);
            }
        }

        // Define roles with their assigned permissions
        $roles = [
            [
                'name' => 'Financial Officer',
                'slug' => 'financial-officer',
                'description' => 'Manages all financial transactions, payments, refunds, and financial reports',
                'permissions' => [
                    'view-payments',
                    'process-refunds',
                    'view-financial-reports',
                    'manage-pricing',
                    'view-revenue-analytics',
                    'view-wallets',
                    'manage-wallet-transactions',
                    'view-wallet-reports',
                    'view-subscriptions',
                    'view-enrollments',
                    'view-reports',
                    'export-reports',
                ],
            ],
            [
                'name' => 'Verification Officer',
                'slug' => 'verification-officer',
                'description' => 'Handles verification of instructors, students, courses, and documents',
                'permissions' => [
                    'verify-instructors',
                    'verify-student-documents',
                    'approve-withdrawals',
                    'view-courses',
                    'approve-courses',
                    'publish-courses',
                    'view-users',
                    'ban-users',
                    'view-certificates',
                    'issue-certificates',
                    'revoke-certificates',
                    'view-activity-logs',
                ],
            ],
            [
                'name' => 'Support Officer',
                'slug' => 'support-officer',
                'description' => 'Provides customer support and handles user queries and tickets',
                'permissions' => [
                    'view-support-tickets',
                    'respond-to-tickets',
                    'close-support-tickets',
                    'send-notifications',
                    'view-users',
                    'view-courses',
                    'view-enrollments',
                    'manage-enrollments',
                    'cancel-enrollments',
                    'view-payments',
                    'view-certificates',
                    'view-reports',
                ],
            ],
            [
                'name' => 'Content Manager',
                'slug' => 'content-manager',
                'description' => 'Manages courses, instructors, and educational content',
                'permissions' => [
                    'view-courses',
                    'create-courses',
                    'edit-courses',
                    'delete-courses',
                    'approve-courses',
                    'publish-courses',
                    'view-users',
                    'verify-instructors',
                    'view-enrollments',
                    'view-certificates',
                    'issue-certificates',
                    'view-reports',
                    'view-analytics-dashboard',
                ],
            ],
            [
                'name' => 'Operations Manager',
                'slug' => 'operations-manager',
                'description' => 'Full access to all operational aspects except system settings',
                'permissions' => [
                    'view-users',
                    'create-users',
                    'edit-users',
                    'ban-users',
                    'view-courses',
                    'create-courses',
                    'edit-courses',
                    'approve-courses',
                    'publish-courses',
                    'view-enrollments',
                    'manage-enrollments',
                    'view-payments',
                    'process-refunds',
                    'view-financial-reports',
                    'view-wallets',
                    'view-subscriptions',
                    'manage-subscription-plans',
                    'view-certificates',
                    'issue-certificates',
                    'verify-instructors',
                    'verify-student-documents',
                    'view-support-tickets',
                    'respond-to-tickets',
                    'close-support-tickets',
                    'view-reports',
                    'view-analytics-dashboard',
                    'export-reports',
                    'view-activity-logs',
                ],
            ],
        ];

        // Create roles and assign permissions
        foreach ($roles as $roleData) {
            $role = AdminRole::create([
                'name' => $roleData['name'],
                'slug' => $roleData['slug'],
                'description' => $roleData['description'],
                'is_active' => true,
            ]);

            // Attach permissions
            $permissionIds = [];
            foreach ($roleData['permissions'] as $permissionSlug) {
                if (isset($createdPermissions[$permissionSlug])) {
                    $permissionIds[] = $createdPermissions[$permissionSlug]->id;
                }
            }
            $role->permissions()->attach($permissionIds);

            $this->command->info("Created role: {$role->name} with " . count($permissionIds) . " permissions");
        }

        $this->command->info("Admin roles and permissions seeded successfully!");
        $this->command->info("Total Permissions: " . AdminPermission::count());
        $this->command->info("Total Roles: " . AdminRole::count());
    }
}
