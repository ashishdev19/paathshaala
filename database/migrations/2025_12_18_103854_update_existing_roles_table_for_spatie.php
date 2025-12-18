<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if roles table exists
        if (Schema::hasTable('roles')) {
            // Check if it has the old structure (slug, description columns)
            if (Schema::hasColumn('roles', 'slug')) {
                // This is the old custom roles table, we need to update it
                
                // Add guard_name column if it doesn't exist
                if (!Schema::hasColumn('roles', 'guard_name')) {
                    Schema::table('roles', function (Blueprint $table) {
                        $table->string('guard_name')->default('web')->after('name');
                    });
                }
                
                // Update existing records to have guard_name
                DB::table('roles')->whereNull('guard_name')->update(['guard_name' => 'web']);
                
                // Drop slug and description columns if they exist
                Schema::table('roles', function (Blueprint $table) {
                    if (Schema::hasColumn('roles', 'slug')) {
                        $table->dropColumn('slug');
                    }
                    if (Schema::hasColumn('roles', 'description')) {
                        $table->dropColumn('description');
                    }
                });
                
                // Add unique constraint for name and guard_name
                // Drop existing unique indexes if they exist
                $this->dropIndexIfExists('roles', 'roles_name_unique');
                $this->dropIndexIfExists('roles', 'roles_slug_unique');
                Schema::table('roles', function (Blueprint $table) {
                    $table->unique(['name', 'guard_name']);
                });
            }
        }
        
        // Check if permissions table exists
        if (Schema::hasTable('permissions')) {
            if (Schema::hasColumn('permissions', 'slug')) {
                // Add guard_name column if it doesn't exist
                if (!Schema::hasColumn('permissions', 'guard_name')) {
                    Schema::table('permissions', function (Blueprint $table) {
                        $table->string('guard_name')->default('web')->after('name');
                    });
                }
                
                // Update existing records to have guard_name
                DB::table('permissions')->whereNull('guard_name')->update(['guard_name' => 'web']);
                
                // Drop slug and description columns if they exist
                Schema::table('permissions', function (Blueprint $table) {
                    if (Schema::hasColumn('permissions', 'slug')) {
                        $table->dropColumn('slug');
                    }
                    if (Schema::hasColumn('permissions', 'description')) {
                        $table->dropColumn('description');
                    }
                });
                
                // Add unique constraint for name and guard_name
                // Drop existing unique indexes if they exist
                $this->dropIndexIfExists('permissions', 'permissions_name_unique');
                $this->dropIndexIfExists('permissions', 'permissions_slug_unique');
                Schema::table('permissions', function (Blueprint $table) {
                    $table->unique(['name', 'guard_name']);
                });
            }
        }
        
        // Drop old role_permissions table if it exists (Spatie uses role_has_permissions)
        if (Schema::hasTable('role_permissions')) {
            Schema::dropIfExists('role_permissions');
        }
        
        // Remove role_id column from users table if it exists
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role_id')) {
            // First, migrate data from role_id to Spatie's model_has_roles table
            $users = DB::table('users')->whereNotNull('role_id')->get();
            foreach ($users as $user) {
                $role = DB::table('roles')->where('id', $user->role_id)->first();
                if ($role) {
                    // Check if model_has_roles exists
                    if (Schema::hasTable('model_has_roles')) {
                        // Check if assignment already exists
                        $exists = DB::table('model_has_roles')
                            ->where('role_id', $role->id)
                            ->where('model_type', 'App\\Models\\User')
                            ->where('model_id', $user->id)
                            ->exists();
                        
                        if (!$exists) {
                            DB::table('model_has_roles')->insert([
                                'role_id' => $role->id,
                                'model_type' => 'App\\Models\\User',
                                'model_id' => $user->id,
                            ]);
                        }
                    }
                }
            }
            
            // Drop foreign key if exists
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'role_id' AND REFERENCED_TABLE_NAME IS NOT NULL");
            foreach ($foreignKeys as $fk) {
                DB::statement("ALTER TABLE users DROP FOREIGN KEY `{$fk->CONSTRAINT_NAME}`");
            }
            
            // Now drop the role_id column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role_id');
            });
        }
    }
    
    /**
     * Helper method to drop index if it exists
     */
    private function dropIndexIfExists($table, $index)
    {
        $exists = DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = '{$index}'");
        if (!empty($exists)) {
            DB::statement("ALTER TABLE `{$table}` DROP INDEX `{$index}`");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We won't reverse this migration as it's a one-way data migration
        // from old custom role system to Spatie's package
    }
};
