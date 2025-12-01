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
        // ============================================
        // ADMIN DASHBOARD CREDENTIALS
        // ============================================
        // Email: admin@paathshaala.com
        // Password: admin123
        // ============================================
        
        $admin = User::firstOrCreate(
            ['email' => 'admin@paathshaala.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('admin123'),
                'phone' => '+91 9999999999',
                'address' => 'Paathshaala Headquarters, New Delhi',
                'email_verified_at' => now(),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // ============================================
        // PROFESSOR/TEACHER DASHBOARD CREDENTIALS
        // ============================================
        // Email: professor@paathshaala.com
        // Password: professor123
        // ============================================
        
        $teacher = User::firstOrCreate(
            ['email' => 'professor@paathshaala.com'],
            [
                'name' => 'Dr. Rajesh Kumar',
                'password' => Hash::make('professor123'),
                'phone' => '+91 8888888888',
                'address' => 'Department of Computer Science, Mumbai',
                'email_verified_at' => now(),
            ]
        );

        if (!$teacher->hasRole('teacher')) {
            $teacher->assignRole('teacher');
        }

        // Alternative teacher account
        $teacher2 = User::firstOrCreate(
            ['email' => 'teacher@paathshaala.com'],
            [
                'name' => 'Prof. Priya Sharma',
                'password' => Hash::make('teacher123'),
                'phone' => '+91 8877665544',
                'address' => 'Department of Mathematics, Bangalore',
                'email_verified_at' => now(),
            ]
        );

        if (!$teacher2->hasRole('teacher')) {
            $teacher2->assignRole('teacher');
        }

        // ============================================
        // STUDENT DASHBOARD CREDENTIALS
        // ============================================
        // Email: student@paathshaala.com
        // Password: student123
        // ============================================
        
        $student = User::firstOrCreate(
            ['email' => 'student@paathshaala.com'],
            [
                'name' => 'Amit Singh',
                'password' => Hash::make('student123'),
                'phone' => '+91 7777777777',
                'address' => 'Student Hostel, Pune',
                'email_verified_at' => now(),
            ]
        );

        if (!$student->hasRole('student')) {
            $student->assignRole('student');
        }

        // Additional student account
        $student2 = User::firstOrCreate(
            ['email' => 'student2@paathshaala.com'],
            [
                'name' => 'Sneha Patel',
                'password' => Hash::make('student123'),
                'phone' => '+91 7766554433',
                'address' => 'Student Residence, Delhi',
                'email_verified_at' => now(),
            ]
        );

        if (!$student2->hasRole('student')) {
            $student2->assignRole('student');
        }

        echo "\n✅ Test users created successfully!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 ADMIN LOGIN\n";
        echo "   Email: admin@paathshaala.com\n";
        echo "   Password: admin123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 PROFESSOR LOGIN\n";
        echo "   Email: professor@paathshaala.com\n";
        echo "   Password: professor123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 STUDENT LOGIN\n";
        echo "   Email: student@paathshaala.com\n";
        echo "   Password: student123\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
