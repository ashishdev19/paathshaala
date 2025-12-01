<?php

/**
 * Wallet System Test Script
 * 
 * Run this to verify the wallet system is working correctly.
 * 
 * Usage: php artisan tinker < test_wallet_system.php
 */

echo "🎓 PAATHSHAALA WALLET SYSTEM TEST\n";
echo "================================\n\n";

// 1. Check if platform settings exist
echo "1️⃣  Checking Platform Settings...\n";
$settings = \App\Models\PlatformSetting::all();
if ($settings->count() > 0) {
    echo "   ✅ Found " . $settings->count() . " settings:\n";
    foreach ($settings as $setting) {
        echo "      - {$setting->key}: {$setting->value}\n";
    }
} else {
    echo "   ❌ No settings found! Run migrations again.\n";
}
echo "\n";

// 2. Create test wallets
echo "2️⃣  Creating Test Wallets...\n";

// Find or create test student
$student = \App\Models\User::byRole('student')->first();
if ($student) {
    $studentWallet = $student->getOrCreateWallet();
    echo "   ✅ Student wallet created: ID {$studentWallet->id}, Balance: ₹{$studentWallet->balance}\n";
} else {
    echo "   ⚠️  No student found. Create a student user first.\n";
}

// Find or create test teacher
$teacher = \App\Models\User::byRole('instructor')->first();
if ($teacher) {
    $teacherWallet = $teacher->getOrCreateWallet();
    echo "   ✅ Teacher wallet created: ID {$teacherWallet->id}, Balance: ₹{$teacherWallet->balance}\n";
} else {
    echo "   ⚠️  No teacher found. Create a teacher user first.\n";
}
echo "\n";

// 3. Test WalletService
if (isset($studentWallet)) {
    echo "3️⃣  Testing WalletService...\n";
    $walletService = new \App\Services\WalletService();
    
    try {
        // Credit student wallet
        $transaction = $walletService->credit(
            $studentWallet,
            1000,
            'Test top-up',
            ['test' => true]
        );
        echo "   ✅ Credited ₹1000 to student wallet\n";
        echo "      Transaction ID: {$transaction->id}, Reference: {$transaction->reference}\n";
        
        // Check balance
        $studentWallet->refresh();
        echo "   ✅ New balance: ₹{$studentWallet->balance}\n";
        
        // Test debit
        $debitTxn = $walletService->debit(
            $studentWallet,
            500,
            'Test course purchase',
            ['course_id' => 1]
        );
        echo "   ✅ Debited ₹500 from student wallet\n";
        
        $studentWallet->refresh();
        echo "   ✅ New balance: ₹{$studentWallet->balance}\n";
        
    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// 4. Test withdrawal request creation
if (isset($teacherWallet)) {
    echo "4️⃣  Testing Withdrawal Request...\n";
    
    // First credit some money to teacher
    try {
        $walletService = new \App\Services\WalletService();
        $walletService->credit($teacherWallet, 2000, 'Test earnings');
        $teacherWallet->refresh();
        echo "   ✅ Credited ₹2000 to teacher wallet (simulated earnings)\n";
        echo "   ✅ Teacher balance: ₹{$teacherWallet->balance}\n";
        
        // Create withdrawal request
        $withdrawRequest = \App\Models\WithdrawRequest::create([
            'teacher_id' => $teacher->id,
            'amount' => 1000,
            'fee' => 20, // 2%
            'net_amount' => 980,
            'payment_method' => 'upi',
            'payment_details' => ['upi_id' => 'test@upi'],
            'status' => 'pending',
            'requested_at' => now(),
        ]);
        echo "   ✅ Withdrawal request created: ID {$withdrawRequest->id}\n";
        echo "      Amount: ₹{$withdrawRequest->amount}, Net: ₹{$withdrawRequest->net_amount}\n";
        
    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// 5. Test wallet top-up
if (isset($student)) {
    echo "5️⃣  Testing Wallet Top-up...\n";
    
    try {
        $topup = \App\Models\WalletTopup::create([
            'student_id' => $student->id,
            'amount' => 500,
            'gateway' => 'test',
            'txn_id' => 'TEST_' . time(),
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        echo "   ✅ Top-up record created: ID {$topup->id}\n";
        echo "      Amount: ₹{$topup->amount}, Status: {$topup->status}\n";
        
    } catch (\Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// 6. Summary
echo "📊 SUMMARY\n";
echo "=========\n";
echo "Total Wallets: " . \App\Models\Wallet::count() . "\n";
echo "Total Transactions: " . \App\Models\WalletTransaction::count() . "\n";
echo "Total Withdrawals: " . \App\Models\WithdrawRequest::count() . "\n";
echo "Total Top-ups: " . \App\Models\WalletTopup::count() . "\n";
echo "\n";

echo "✅ WALLET SYSTEM TEST COMPLETE!\n";
echo "================================\n";
