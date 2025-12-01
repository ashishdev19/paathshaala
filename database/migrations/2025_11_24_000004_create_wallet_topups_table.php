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
        Schema::create('wallet_topups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->string('gateway')->nullable(); // razorpay, stripe, paytm, etc
            $table->string('txn_id')->unique()->nullable(); // Gateway transaction ID
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->json('meta')->nullable(); // Gateway response
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('student_id');
            $table->index('txn_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_topups');
    }
};
