<?php
require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

// Disable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=0');

// Drop old Spatie tables if they exist
$tables_to_drop = ['model_has_permissions', 'model_has_roles', 'role_has_permissions', 'permissions', 'roles'];

foreach ($tables_to_drop as $table) {
    try {
        DB::statement("DROP TABLE IF EXISTS $table");
        echo "✅ Dropped table: $table\n";
    } catch (\Exception $e) {
        echo "❌ Could not drop $table: " . $e->getMessage() . "\n";
    }
}

// Re-enable foreign key checks
DB::statement('SET FOREIGN_KEY_CHECKS=1');

echo "\n✅ Cleanup complete!\n";
