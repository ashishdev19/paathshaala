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
        Schema::table('enrollments', function (Blueprint $table) {
            $table->timestamp('expires_at')->nullable()->after('enrolled_at'); // When the enrollment expires
            $table->boolean('is_expired')->default(false)->after('expires_at'); // Whether the enrollment has expired
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollments', function (Blueprint $table) {
            $table->dropColumn(['expires_at', 'is_expired']);
        });
    }
};
