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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->nullable()->after('phone'); // instructor or student
            $table->string('profession_type')->nullable()->after('user_type');
            $table->string('city')->nullable()->after('profession_type');
            $table->string('state')->nullable()->after('city');
            $table->string('pincode', 10)->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'profession_type', 'city', 'state', 'pincode']);
        });
    }
};
