<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update existing courses table with new fields
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                // Check if columns don't already exist before adding
                if (!Schema::hasColumn('courses', 'subtitle')) {
                    $table->string('subtitle')->nullable()->after('title');
                }
                if (!Schema::hasColumn('courses', 'language')) {
                    $table->string('language')->default('en')->after('category');
                }
                if (!Schema::hasColumn('courses', 'course_mode')) {
                    $table->enum('course_mode', ['online', 'offline', 'hybrid'])->default('online')->after('language');
                }
                if (!Schema::hasColumn('courses', 'promo_video_url')) {
                    $table->string('promo_video_url')->nullable()->after('thumbnail');
                }
                if (!Schema::hasColumn('courses', 'demo_pdf')) {
                    $table->string('demo_pdf')->nullable()->after('promo_video_url');
                }
                if (!Schema::hasColumn('courses', 'demo_lecture')) {
                    $table->string('demo_lecture')->nullable()->after('demo_pdf');
                }
                if (!Schema::hasColumn('courses', 'is_free')) {
                    $table->boolean('is_free')->default(false)->after('price');
                }
                if (!Schema::hasColumn('courses', 'discount_price')) {
                    $table->decimal('discount_price', 10, 2)->nullable()->after('is_free');
                }
                if (!Schema::hasColumn('courses', 'validity_days')) {
                    $table->integer('validity_days')->nullable()->after('discount_price');
                }
                if (!Schema::hasColumn('courses', 'meta_title')) {
                    $table->string('meta_title')->nullable()->after('validity_days');
                }
                if (!Schema::hasColumn('courses', 'meta_description')) {
                    $table->text('meta_description')->nullable()->after('meta_title');
                }
                if (!Schema::hasColumn('courses', 'slug')) {
                    $table->string('slug')->unique()->nullable()->after('meta_description');
                }
                if (!Schema::hasColumn('courses', 'status')) {
                    $table->enum('status', ['draft', 'under_review', 'published', 'rejected'])->default('draft')->after('slug');
                }
                if (!Schema::hasColumn('courses', 'rejection_reason')) {
                    $table->text('rejection_reason')->nullable()->after('status');
                }
                if (!Schema::hasColumn('courses', 'approved_by')) {
                    $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('courses')) {
            Schema::table('courses', function (Blueprint $table) {
                $columns = ['subtitle', 'language', 'course_mode', 'promo_video_url', 'demo_pdf', 'demo_lecture', 
                           'is_free', 'discount_price', 'meta_title', 'meta_description', 'slug', 'status', 
                           'rejection_reason', 'approved_by'];
                
                foreach ($columns as $column) {
                    if (Schema::hasColumn('courses', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
