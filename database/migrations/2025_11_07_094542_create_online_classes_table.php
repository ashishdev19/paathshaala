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
        Schema::create('online_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['live', 'recorded']);
            $table->string('video_url')->nullable(); // For recorded classes or recorded live sessions
            $table->string('meeting_link')->nullable(); // For live classes
            $table->string('meeting_id')->nullable();
            $table->string('meeting_password')->nullable();
            $table->datetime('scheduled_at')->nullable(); // For live classes
            $table->integer('duration_minutes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // For ordering classes within a course
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_classes');
    }
};
