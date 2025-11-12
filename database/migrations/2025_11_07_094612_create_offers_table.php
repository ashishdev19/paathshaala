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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('code')->unique(); // Discount code
            $table->enum('type', ['percentage', 'fixed_amount']);
            $table->decimal('value', 10, 2); // Percentage or fixed amount
            $table->decimal('minimum_amount', 10, 2)->nullable(); // Minimum purchase amount
            $table->integer('usage_limit')->nullable(); // Maximum number of uses
            $table->integer('used_count')->default(0);
            $table->datetime('valid_from');
            $table->datetime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->json('applicable_courses')->nullable(); // Course IDs this offer applies to
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
