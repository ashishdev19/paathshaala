<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration to clean up the role/permission system
 * 
 * This migration:
 * 1. Removes the user_type column from users table (using Spatie roles instead)
 * 2. Drops all custom admin role/permission tables (using Spatie exclusively)
 * 
 * IMPORTANT: Run seeder after this migration to ensure Spatie roles are set up:
 * php artisan db:seed --class=RoleSeeder
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ============================================
        // STEP 1: Remove user_type column from users
        // ============================================
        if (Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('user_type');
            });
        }

        // ============================================
        // STEP 2: Drop custom admin role/permission tables
        // These are redundant as we use Spatie permission package
        // ============================================
        
        // Drop pivot table first (foreign key constraints)
        Schema::dropIfExists('admin_role_permission');
        
        // Drop admin accounts table
        Schema::dropIfExists('admin_accounts');
        
        // Drop admin permissions table
        Schema::dropIfExists('admin_permissions');
        
        // Drop admin roles table
        Schema::dropIfExists('admin_roles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // ============================================
        // STEP 1: Restore user_type column
        // ============================================
        if (!Schema::hasColumn('users', 'user_type')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_type')->nullable()->after('phone');
            });
        }

        // ============================================
        // STEP 2: Recreate admin role tables (if needed)
        // ============================================
        
        Schema::create('admin_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('module')->nullable();
            $table->timestamps();
        });

        Schema::create('admin_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('admin_role_id')->nullable()->constrained('admin_roles')->onDelete('set null');
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('admin_role_permission', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_role_id')->constrained('admin_roles')->onDelete('cascade');
            $table->foreignId('admin_permission_id')->constrained('admin_permissions')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['admin_role_id', 'admin_permission_id']);
        });
    }
};
