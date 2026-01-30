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
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->onDelete('cascade'); // User A who shared
            $table->foreignId('referred_id')->constrained('users')->onDelete('cascade'); // User B who joined
            $table->string('referral_code', 20);
            $table->decimal('referrer_credit', 10, 2)->default(100.00); // Credit to User A
            $table->decimal('referred_discount', 10, 2)->default(100.00); // Discount to User B
            $table->boolean('credit_applied')->default(false); // Has User A received credit?
            $table->boolean('discount_applied')->default(false); // Has User B used discount?
            $table->timestamp('credit_applied_at')->nullable();
            $table->timestamp('discount_applied_at')->nullable();
            $table->foreignId('enrollment_id')->nullable()->constrained()->onDelete('set null'); // For student purchases
            $table->timestamps();
            
            $table->index(['referrer_id', 'credit_applied']);
            $table->index(['referred_id', 'discount_applied']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
