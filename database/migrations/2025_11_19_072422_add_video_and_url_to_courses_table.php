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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('video_file')->nullable()->after('thumbnail');
            $table->string('video_url')->nullable()->after('video_file');
            $table->json('course_urls')->nullable()->after('video_url'); // For multiple URLs
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['video_file', 'video_url', 'course_urls']);
        });
    }
};
