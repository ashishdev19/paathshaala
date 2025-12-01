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
        Schema::create('teacher_subscription_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_plan_id')->nullable();
            $table->unsignedBigInteger('to_plan_id');
            $table->enum('action', ['created', 'upgraded', 'downgraded', 'renewed', 'cancelled']);
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('action_date')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable(); // Admin or system
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('from_plan_id')->references('id')->on('subscription_plans')->onDelete('set null');
            $table->foreign('to_plan_id')->references('id')->on('subscription_plans')->onDelete('restrict');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subscription_history');
    }
};
