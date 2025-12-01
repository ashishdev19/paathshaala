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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['credit', 'debit', 'hold', 'release', 'payout', 'refund', 'commission']);
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_before', 12, 2);
            $table->decimal('balance_after', 12, 2);
            $table->string('reference')->nullable(); // Unique transaction reference
            $table->json('meta')->nullable(); // Payment gateway response, enrollment_id, course_id etc
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('wallet_id');
            $table->index('type');
            $table->index('reference');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
