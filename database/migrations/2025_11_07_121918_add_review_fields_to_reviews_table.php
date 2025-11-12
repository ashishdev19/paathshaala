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
        Schema::table('reviews', function (Blueprint $table) {
            $table->integer('rating')->unsigned()->nullable()->after('teacher_review'); // Overall rating 1-5
            $table->text('review_text')->nullable()->after('rating');
            $table->json('pros')->nullable()->after('review_text');
            $table->json('cons')->nullable()->after('pros');
            $table->boolean('is_verified')->default(false)->after('cons');
            $table->boolean('is_featured')->default(false)->after('is_verified');
            $table->timestamp('approved_at')->nullable()->after('is_approved');
            $table->integer('helpful_count')->default(0)->after('approved_at');
            $table->json('tags')->nullable()->after('helpful_count'); // course quality, instructor, content, etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'rating',
                'review_text',
                'pros',
                'cons',
                'is_verified',
                'is_featured',
                'approved_at',
                'helpful_count',
                'tags'
            ]);
        });
    }
};
