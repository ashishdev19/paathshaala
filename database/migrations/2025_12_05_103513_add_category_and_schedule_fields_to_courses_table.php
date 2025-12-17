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
            $table->foreignId('category_id')->nullable()->after('teacher_id')->constrained('course_categories')->onDelete('cascade');
            $table->string('duration', 100)->nullable()->after('description');
            $table->time('class_start_time')->nullable()->after('duration');
            $table->time('class_end_time')->nullable()->after('class_start_time');
            $table->enum('mode', ['online', 'offline', 'hybrid'])->default('online')->after('class_end_time');
            $table->date('batch_start_date')->nullable()->after('mode');
            $table->date('batch_end_date')->nullable()->after('batch_start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn([
                'category_id',
                'duration',
                'class_start_time',
                'class_end_time',
                'mode',
                'batch_start_date',
                'batch_end_date'
            ]);
        });
    }
};
