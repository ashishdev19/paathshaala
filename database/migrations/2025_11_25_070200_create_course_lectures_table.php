<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')->constrained('course_sections')->cascadeOnDelete();
            $table->string('title');
            $table->enum('type', ['video', 'pdf', 'quiz', 'assignment', 'live'])->default('video');
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable();
            $table->integer('duration')->nullable(); // in seconds
            $table->boolean('is_preview')->default(false);
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_lectures');
    }
};
