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
        Schema::create('referral_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->string('type')->default('string'); // string, integer, decimal, boolean
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('referral_settings')->insert([
            [
                'key' => 'referrer_credit_amount',
                'value' => '100.00',
                'type' => 'decimal',
                'description' => 'Amount credited to User A when User B signs up (in INR)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referred_discount_amount',
                'value' => '100.00',
                'type' => 'decimal',
                'description' => 'Discount amount given to User B on signup (in INR)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'credit_on_signup',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'If true, User A gets credit immediately on signup. If false, after User B makes first purchase.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'referral_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable/disable referral system',
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
        Schema::dropIfExists('referral_settings');
    }
};
