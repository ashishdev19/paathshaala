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
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('paid_via_wallet')->default(false)->after('payment_method');
            $table->foreignId('wallet_transaction_id')->nullable()->constrained('wallet_transactions')->onDelete('set null')->after('paid_via_wallet');
            $table->decimal('platform_commission', 10, 2)->default(0.00)->after('final_amount');
            $table->decimal('teacher_earnings', 10, 2)->default(0.00)->after('platform_commission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['wallet_transaction_id']);
            $table->dropColumn(['paid_via_wallet', 'wallet_transaction_id', 'platform_commission', 'teacher_earnings']);
        });
    }
};
