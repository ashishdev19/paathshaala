<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminAccount;
use App\Models\AdminRole;
use Illuminate\Support\Facades\Hash;

class AdminAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $financialOfficer = AdminRole::where('slug', 'financial-officer')->first();
        $verificationOfficer = AdminRole::where('slug', 'verification-officer')->first();
        $supportOfficer = AdminRole::where('slug', 'support-officer')->first();
        $contentManager = AdminRole::where('slug', 'content-manager')->first();
        $operationsManager = AdminRole::where('slug', 'operations-manager')->first();

        // Create sample admin accounts
        $accounts = [
            [
                'name' => 'Rahul Sharma',
                'email' => 'financial@paathshaala.com',
                'password' => Hash::make('password123'),
                'admin_role_id' => $financialOfficer?->id,
                'phone' => '+91 98765 43210',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Priya Patel',
                'email' => 'verification@paathshaala.com',
                'password' => Hash::make('password123'),
                'admin_role_id' => $verificationOfficer?->id,
                'phone' => '+91 98765 43211',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Amit Kumar',
                'email' => 'support@paathshaala.com',
                'password' => Hash::make('password123'),
                'admin_role_id' => $supportOfficer?->id,
                'phone' => '+91 98765 43212',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sneha Desai',
                'email' => 'content@paathshaala.com',
                'password' => Hash::make('password123'),
                'admin_role_id' => $contentManager?->id,
                'phone' => '+91 98765 43213',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Vikram Singh',
                'email' => 'operations@paathshaala.com',
                'password' => Hash::make('password123'),
                'admin_role_id' => $operationsManager?->id,
                'phone' => '+91 98765 43214',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($accounts as $accountData) {
            if ($accountData['admin_role_id']) {
                $account = AdminAccount::create($accountData);
                $this->command->info("Created admin account: {$account->name} ({$account->email}) - Role: {$account->role->name}");
            }
        }

        $this->command->info("Admin accounts seeded successfully!");
        $this->command->info("Default Password for all accounts: password123");
        $this->command->info("Total Admin Accounts: " . AdminAccount::count());
    }
}
