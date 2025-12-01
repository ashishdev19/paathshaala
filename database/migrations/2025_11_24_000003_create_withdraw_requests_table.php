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
        Schema::create('withdraw_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2); // Requested amount
            $table->decimal('fee', 12, 2)->default(0.00); // Platform fee if any
            $table->decimal('net_amount', 12, 2); // amount - fee
            $table->enum('status', ['pending', 'approved', 'rejected', 'paid'])->default('pending');
            $table->string('payment_method')->nullable(); // Bank transfer, UPI, etc
            $table->json('payment_details')->nullable(); // Bank account, UPI ID, etc
            $table->text('teacher_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->string('payout_reference')->nullable(); // UTR/Transaction ID
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('teacher_id');
            $table->index('status');
            $table->index('requested_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_requests');
    }
};
