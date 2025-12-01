<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\WalletTopup;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Student Wallet Controller
 * 
 * Handles student wallet operations: top-up, view balance, transactions
 */
class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Display wallet dashboard
     */
    public function index()
    {
        $student = Auth::user();
        $wallet = $student->getOrCreateWallet();
        
        // Get recent transactions
        $transactions = $wallet->transactions()
            ->with('creator')
            ->latest()
            ->paginate(20);

        // Get top-up history
        $topups = $student->walletTopups()
            ->latest()
            ->paginate(10);

        // Get wallet statistics
        $stats = [
            'total_topup' => $student->walletTopups()->completed()->sum('amount'),
            'total_spent' => $wallet->transactionsByType('debit')->sum('amount'),
            'pending_topups' => $student->walletTopups()->pending()->sum('amount'),
        ];

        return view('students.wallet.index', compact(
            'wallet',
            'transactions',
            'topups',
            'stats'
        ));
    }

    /**
     * Show top-up form
     */
    public function topupForm()
    {
        $student = Auth::user();
        $wallet = $student->getOrCreateWallet();

        return view('students.wallet.topup', compact('wallet'));
    }

    /**
     * Initiate wallet top-up
     */
    public function initiateTopup(Request $request)
    {
        $student = Auth::user();
        $wallet = $student->getOrCreateWallet();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:100|max:50000',
            'gateway' => 'required|string|in:razorpay,stripe,paytm',
        ]);

        // Create topup record
        $topup = WalletTopup::create([
            'student_id' => $student->id,
            'amount' => $validated['amount'],
            'gateway' => $validated['gateway'],
            'status' => WalletTopup::STATUS_PENDING,
        ]);

        // TODO: Integrate with payment gateway
        // For now, we'll simulate immediate success for testing
        // In production, this would redirect to payment gateway

        // Simulate payment gateway response
        if ($request->has('simulate_success')) {
            return $this->handleTopupSuccess($topup->id, 'TEST_TXN_' . time());
        }

        // Return payment gateway redirect URL or form
        return view('student.wallet.payment-gateway', compact('topup', 'wallet'));
    }

    /**
     * Handle successful top-up (webhook/callback)
     */
    public function handleTopupSuccess($topupId, $txnId)
    {
        $topup = WalletTopup::findOrFail($topupId);

        // Check if already processed (idempotency)
        if ($topup->isCompleted()) {
            return redirect()->route('student.wallet.index')
                ->with('info', 'This top-up has already been processed.');
        }

        try {
            // Update topup status
            $topup->update([
                'status' => WalletTopup::STATUS_COMPLETED,
                'txn_id' => $txnId,
                'completed_at' => now(),
            ]);

            // Credit wallet
            $wallet = $topup->student->wallet;
            $this->walletService->credit(
                $wallet,
                $topup->amount,
                'Wallet top-up via ' . $topup->gateway,
                ['topup_id' => $topup->id, 'txn_id' => $txnId]
            );

            // TODO: Send notification
            // event(new WalletTopupCompleted($topup));

            return redirect()->route('student.wallet.index')
                ->with('success', "Wallet topped up successfully! ₹{$topup->amount} credited.");
        } catch (\Exception $e) {
            // Log error
            \Log::error('Wallet topup failed: ' . $e->getMessage());

            $topup->update(['status' => WalletTopup::STATUS_FAILED]);

            return redirect()->route('student.wallet.index')
                ->with('error', 'Top-up processing failed. Please contact support.');
        }
    }

    /**
     * Payment gateway webhook
     */
    public function webhook(Request $request)
    {
        // TODO: Implement actual payment gateway webhook verification
        // This is a placeholder for gateway webhook handling
        
        $txnId = $request->input('txn_id');
        $status = $request->input('status');
        $amount = $request->input('amount');

        // Find topup by transaction ID or reference
        $topup = WalletTopup::where('txn_id', $txnId)->first();

        if (!$topup) {
            return response()->json(['error' => 'Invalid transaction'], 404);
        }

        if ($status === 'success' && !$topup->isCompleted()) {
            $this->handleTopupSuccess($topup->id, $txnId);
        } elseif ($status === 'failed') {
            $topup->update(['status' => WalletTopup::STATUS_FAILED]);
        }

        return response()->json(['success' => true]);
    }
}
