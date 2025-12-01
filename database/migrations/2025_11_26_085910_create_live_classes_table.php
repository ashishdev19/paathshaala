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
        Schema::create('live_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->string('topic');
            $table->text('description')->nullable();
            $table->enum('mode', ['online', 'offline', 'hybrid'])->default('online');
            $table->string('room_name')->unique();
            $table->string('meeting_link');
            $table->dateTime('start_datetime');
            $table->integer('duration'); // in minutes
            $table->boolean('allow_chat')->default(true);
            $table->boolean('allow_mic')->default(true);
            $table->boolean('allow_video')->default(true);
            $table->enum('status', ['scheduled', 'live', 'ended', 'cancelled'])->default('scheduled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_classes');
    }
};
