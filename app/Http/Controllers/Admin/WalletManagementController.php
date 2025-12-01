<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\WithdrawRequest;
use App\Services\WalletService;
use Illuminate\Http\Request;

/**
 * Admin Wallet Management Controller
 * 
 * Handles admin operations: approve/reject withdrawals, manage settings, view reports
 */
class WalletManagementController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Wallet dashboard - overview of all wallets
     */
    public function index()
    {
        $stats = [
            'total_wallets' => Wallet::count(),
            'total_balance' => Wallet::sum('balance'),
            'total_reserved' => Wallet::sum('reserved_amount'),
            'pending_withdrawals' => WithdrawRequest::pending()->count(),
            'pending_withdrawal_amount' => WithdrawRequest::pending()->sum('amount'),
            'total_withdrawn' => WithdrawRequest::paid()->sum('net_amount'),
        ];

        // Recent transactions
        $recentTransactions = WalletTransaction::with(['wallet.user'])
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.wallet.index', compact('stats', 'recentTransactions'));
    }

    /**
     * List all withdraw requests
     */
    public function withdrawRequests(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = WithdrawRequest::with(['teacher', 'processor']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $withdrawRequests = $query->latest('requested_at')->paginate(20);

        return view('admin.wallet.withdraw-requests', compact('withdrawRequests', 'status'));
    }

    /**
     * Show withdraw request details
     */
    public function showWithdrawRequest(WithdrawRequest $withdrawRequest)
    {
        $withdrawRequest->load(['teacher', 'processor']);

        return view('admin.wallet.withdraw-details', compact('withdrawRequest'));
    }

    /**
     * Approve withdraw request
     */
    public function approveWithdraw(Request $request, WithdrawRequest $withdrawRequest)
    {
        if (!$withdrawRequest->isPending()) {
            return back()->with('error', 'Only pending requests can be approved');
        }

        $validated = $request->validate([
            'admin_note' => 'nullable|string|max:500',
        ]);

        $withdrawRequest->update([
            'status' => WithdrawRequest::STATUS_APPROVED,
            'admin_note' => $validated['admin_note'] ?? null,
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);

        // TODO: Send notification to teacher
        // event(new WithdrawRequestApproved($withdrawRequest));

        return redirect()->route('admin.wallet.withdraw-requests')
            ->with('success', 'Withdrawal request approved. Now process the payout.');
    }

    /**
     * Mark withdraw as paid (after payout is completed)
     */
    public function markWithdrawPaid(Request $request, WithdrawRequest $withdrawRequest)
    {
        if (!$withdrawRequest->isApproved()) {
            return back()->with('error', 'Only approved requests can be marked as paid');
        }

        $validated = $request->validate([
            'payout_reference' => 'required|string|max:255',
            'admin_note' => 'nullable|string|max:500',
        ]);

        try {
            // Deduct from teacher wallet
            $teacher = $withdrawRequest->teacher;
            $wallet = $teacher->wallet;

            $this->walletService->payout(
                $wallet,
                $withdrawRequest->amount,
                'Withdrawal payout - ' . $withdrawRequest->payment_method,
                [
                    'withdraw_request_id' => $withdrawRequest->id,
                    'payout_reference' => $validated['payout_reference'],
                ],
                auth()->id()
            );

            // Update withdraw request
            $withdrawRequest->update([
                'status' => WithdrawRequest::STATUS_PAID,
                'payout_reference' => $validated['payout_reference'],
                'admin_note' => $validated['admin_note'] ?? $withdrawRequest->admin_note,
                'processed_at' => now(),
                'processed_by' => auth()->id(),
            ]);

            // TODO: Send notification to teacher
            // event(new WithdrawRequestPaid($withdrawRequest));

            return redirect()->route('admin.wallet.withdraw-requests')
                ->with('success', 'Withdrawal marked as paid successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing payout: ' . $e->getMessage());
        }
    }

    /**
     * Reject withdraw request
     */
    public function rejectWithdraw(Request $request, WithdrawRequest $withdrawRequest)
    {
        if (!$withdrawRequest->isPending()) {
            return back()->with('error', 'Only pending requests can be rejected');
        }

        $validated = $request->validate([
            'admin_note' => 'required|string|max:500',
        ]);

        $withdrawRequest->update([
            'status' => WithdrawRequest::STATUS_REJECTED,
            'admin_note' => $validated['admin_note'],
            'processed_at' => now(),
            'processed_by' => auth()->id(),
        ]);

        // TODO: Send notification to teacher
        // event(new WithdrawRequestRejected($withdrawRequest));

        return redirect()->route('admin.wallet.withdraw-requests')
            ->with('success', 'Withdrawal request rejected');
    }

    /**
     * Wallet settings page
     */
    public function settings()
    {
        $settings = [
            'min_withdraw_amount' => PlatformSetting::get('MIN_WITHDRAW_AMOUNT', 500),
            'platform_commission' => PlatformSetting::get('PLATFORM_COMMISSION_PERCENT', 10),
            'withdraw_fee' => PlatformSetting::get('WITHDRAW_FEE_PERCENT', 2),
            'enable_topup' => PlatformSetting::get('ENABLE_WALLET_TOPUP', true),
        ];

        return view('admin.wallet.settings', compact('settings'));
    }

    /**
     * Update wallet settings
     */
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'min_withdraw_amount' => 'required|numeric|min:100',
            'platform_commission' => 'required|numeric|min:0|max:100',
            'withdraw_fee' => 'required|numeric|min:0|max:100',
            'enable_topup' => 'required|boolean',
        ]);

        PlatformSetting::set('MIN_WITHDRAW_AMOUNT', $validated['min_withdraw_amount'], 'decimal');
        PlatformSetting::set('PLATFORM_COMMISSION_PERCENT', $validated['platform_commission'], 'decimal');
        PlatformSetting::set('WITHDRAW_FEE_PERCENT', $validated['withdraw_fee'], 'decimal');
        PlatformSetting::set('ENABLE_WALLET_TOPUP', $validated['enable_topup'], 'boolean');

        return back()->with('success', 'Wallet settings updated successfully');
    }

    /**
     * View all wallets
     */
    public function allWallets(Request $request)
    {
        $wallets = Wallet::with('user')
            ->latest()
            ->paginate(50);

        return view('admin.wallet.all-wallets', compact('wallets'));
    }

    /**
     * View specific user's wallet
     */
    public function userWallet($userId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $wallet = $user->getOrCreateWallet();
        
        $transactions = $wallet->transactions()
            ->with('creator')
            ->latest()
            ->paginate(50);

        return view('admin.wallet.user-wallet', compact('user', 'wallet', 'transactions'));
    }

    /**
     * Manual wallet adjustment (credit/debit)
     */
    public function manualAdjustment(Request $request, $userId)
    {
        $validated = $request->validate([
            'type' => 'required|in:credit,debit',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        try {
            $user = \App\Models\User::findOrFail($userId);
            $wallet = $user->getOrCreateWallet();

            if ($validated['type'] === 'credit') {
                $this->walletService->credit(
                    $wallet,
                    $validated['amount'],
                    $validated['description'],
                    ['manual_adjustment' => true],
                    auth()->id()
                );
            } else {
                $this->walletService->debit(
                    $wallet,
                    $validated['amount'],
                    $validated['description'],
                    ['manual_adjustment' => true],
                    auth()->id()
                );
            }

            return back()->with('success', 'Wallet adjusted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
