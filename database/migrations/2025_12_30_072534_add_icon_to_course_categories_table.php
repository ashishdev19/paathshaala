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
        Schema::table('course_categories', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('name'); // Font Awesome class name like 'fa-heart-pulse'
            $table->boolean('show_on_homepage')->default(true)->after('status');
            $table->integer('display_order')->default(0)->after('show_on_homepage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_categories', function (Blueprint $table) {
            $table->dropColumn(['icon', 'show_on_homepage', 'display_order']);
        });
    }
};
