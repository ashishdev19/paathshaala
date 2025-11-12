<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@paathshaala.com',
            'password' => Hash::make('password'),
            'phone' => '+91 9999999999',
            'address' => 'Paathshaala Headquarters',
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        // Create sample teacher
        $teacher = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'teacher@paathshaala.com',
            'password' => Hash::make('password'),
            'phone' => '+91 8888888888',
            'address' => 'Medical College',
            'email_verified_at' => now(),
        ]);

        $teacher->assignRole('teacher');

        // Create sample student
        $student = User::create([
            'name' => 'Jane Doe',
            'email' => 'student@paathshaala.com',
            'password' => Hash::make('password'),
            'phone' => '+91 7777777777',
            'address' => 'Student Residence',
            'email_verified_at' => now(),
        ]);

        $student->assignRole('student');
    }
}
