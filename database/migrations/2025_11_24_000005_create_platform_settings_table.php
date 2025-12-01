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
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, decimal, boolean, json
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('key');
        });

        // Insert default settings
        DB::table('platform_settings')->insert([
            [
                'key' => 'MIN_WITHDRAW_AMOUNT',
                'value' => '500',
                'type' => 'decimal',
                'description' => 'Minimum amount (INR) a teacher can withdraw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'PLATFORM_COMMISSION_PERCENT',
                'value' => '10',
                'type' => 'decimal',
                'description' => 'Platform commission percentage on course sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'WITHDRAW_FEE_PERCENT',
                'value' => '2',
                'type' => 'decimal',
                'description' => 'Withdrawal processing fee percentage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'ENABLE_WALLET_TOPUP',
                'value' => '1',
                'type' => 'boolean',
                'description' => 'Enable student wallet top-up feature',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
    }
};
