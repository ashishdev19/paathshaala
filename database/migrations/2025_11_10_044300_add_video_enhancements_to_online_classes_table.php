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
        Schema::table('online_classes', function (Blueprint $table) {
            $table->json('video_qualities')->nullable()->after('video_url'); // Store multiple quality URLs
            $table->json('available_speeds')->nullable()->after('video_qualities'); // Available playback speeds
            $table->boolean('allow_offline_download')->default(false)->after('available_speeds');
            $table->integer('total_views')->default(0)->after('allow_offline_download');
            $table->integer('total_watch_time')->default(0)->after('total_views'); // in seconds
            $table->decimal('completion_rate', 5, 2)->default(0)->after('total_watch_time'); // percentage
            $table->boolean('enable_chat')->default(true)->after('completion_rate');
            $table->boolean('enable_polls')->default(false)->after('enable_chat');
            $table->boolean('enable_screen_share')->default(false)->after('enable_polls');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('online_classes', function (Blueprint $table) {
            $table->dropColumn([
                'video_qualities',
                'available_speeds',
                'allow_offline_download',
                'total_views',
                'total_watch_time',
                'completion_rate',
                'enable_chat',
                'enable_polls',
                'enable_screen_share'
            ]);
        });
    }
};
