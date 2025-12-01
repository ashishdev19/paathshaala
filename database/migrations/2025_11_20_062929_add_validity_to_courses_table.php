<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('validity_days')->default(365)->after('price'); // Course validity in days
            $table->boolean('is_lifetime')->default(false)->after('validity_days'); // Whether course has lifetime access
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['validity_days', 'is_lifetime']);
        });
    }
};
