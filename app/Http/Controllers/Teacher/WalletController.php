<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Models\WithdrawRequest;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Teacher Wallet Controller
 * 
 * Handles teacher wallet operations: view balance, transactions, withdraw requests
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
        $teacher = Auth::user();
        $wallet = $teacher->getOrCreateWallet();
        
        // Get recent transactions
        $transactions = $wallet->transactions()
            ->with('creator')
            ->latest()
            ->paginate(20);

        // Get withdraw requests
        $withdrawRequests = $teacher->withdrawRequests()
            ->latest()
            ->paginate(10);

        // Get wallet statistics
        $stats = [
            'total_earned' => $wallet->transactionsByType('credit')->sum('amount'),
            'total_withdrawn' => $teacher->withdrawRequests()->paid()->sum('net_amount'),
            'pending_withdrawals' => $teacher->withdrawRequests()->pending()->sum('amount'),
            'total_commission' => $wallet->transactionsByType('commission')->sum('amount'),
        ];

        // Get platform settings
        $minWithdrawAmount = PlatformSetting::get('MIN_WITHDRAW_AMOUNT', 500);

        return view('instructor.wallet.index', compact(
            'wallet',
            'transactions',
            'withdrawRequests',
            'stats',
            'minWithdrawAmount'
        ));
    }

    /**
     * Show withdraw request form
     */
    public function withdrawForm()
    {
        $teacher = Auth::user();
        $wallet = $teacher->getOrCreateWallet();
        $minWithdrawAmount = PlatformSetting::get('MIN_WITHDRAW_AMOUNT', 500);
        $withdrawFeePercent = PlatformSetting::get('WITHDRAW_FEE_PERCENT', 2);

        return view('instructor.wallet.withdraw', compact(
            'wallet',
            'minWithdrawAmount',
            'withdrawFeePercent'
        ));
    }

    /**
     * Create withdraw request
     */
    public function createWithdrawRequest(Request $request)
    {
        $teacher = Auth::user();
        $wallet = $teacher->getOrCreateWallet();

        $minWithdrawAmount = PlatformSetting::get('MIN_WITHDRAW_AMOUNT', 500);
        $withdrawFeePercent = PlatformSetting::get('WITHDRAW_FEE_PERCENT', 2);

        $validated = $request->validate([
            'amount' => "required|numeric|min:{$minWithdrawAmount}",
            'payment_method' => 'required|string|in:bank_transfer,upi,paytm',
            'payment_details' => 'required|array',
            'payment_details.account_holder' => 'required_if:payment_method,bank_transfer|string',
            'payment_details.bank_name' => 'required_if:payment_method,bank_transfer|string',
            'payment_details.account_number' => 'required_if:payment_method,bank_transfer|string',
            'payment_details.ifsc_code' => 'required_if:payment_method,bank_transfer|string',
            'payment_details.upi_id' => 'required_if:payment_method,upi,paytm|string',
            'note' => 'nullable|string|max:500',
        ]);

        // Check available balance
        if ($wallet->available_balance < $validated['amount']) {
            return back()->withErrors(['amount' => 'Insufficient wallet balance']);
        }

        // Calculate fee and net amount
        $fee = ($validated['amount'] * $withdrawFeePercent) / 100;
        $netAmount = $validated['amount'] - $fee;

        // Create withdraw request
        $withdrawRequest = WithdrawRequest::create([
            'teacher_id' => $teacher->id,
            'amount' => $validated['amount'],
            'fee' => $fee,
            'net_amount' => $netAmount,
            'payment_method' => $validated['payment_method'],
            'payment_details' => $validated['payment_details'],
            'teacher_note' => $validated['note'] ?? null,
            'status' => WithdrawRequest::STATUS_PENDING,
            'requested_at' => now(),
        ]);

        // TODO: Send notification to admin
        // event(new WithdrawRequestCreated($withdrawRequest));

        return redirect()->route('teacher.wallet.index')
            ->with('success', 'Withdrawal request submitted successfully. You will be notified once processed.');
    }

    /**
     * Show single withdraw request
     */
    public function showWithdrawRequest(WithdrawRequest $withdrawRequest)
    {
        // Authorization
        if ($withdrawRequest->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('instructor.wallet.withdraw-details', compact('withdrawRequest'));
    }

    /**
     * Get transaction details (AJAX)
     */
    public function transactionDetails($transactionId)
    {
        $teacher = Auth::user();
        $wallet = $teacher->wallet;

        $transaction = $wallet->transactions()->findOrFail($transactionId);

        return response()->json([
            'success' => true,
            'transaction' => $transaction,
        ]);
    }
}
