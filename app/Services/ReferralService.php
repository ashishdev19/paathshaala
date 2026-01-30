<?php

namespace App\Services;

use App\Models\Referral;
use App\Models\ReferralCode;
use App\Models\ReferralSetting;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReferralService
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Process referral when a new user signs up with a referral code.
     */
    public function processReferralSignup(User $newUser, string $referralCode): ?Referral
    {
        // Check if referral system is enabled
        if (!ReferralSetting::get('referral_enabled', true)) {
            return null;
        }

        // Find the referral code
        $referralCodeModel = ReferralCode::where('code', $referralCode)
            ->where('is_active', true)
            ->first();

        if (!$referralCodeModel) {
            return null;
        }

        // Prevent self-referral
        if ($referralCodeModel->user_id === $newUser->id) {
            return null;
        }

        $referrer = $referralCodeModel->user;

        // Get referral amounts from settings
        $referrerCredit = ReferralSetting::get('referrer_credit_amount', 100.00);
        $referredDiscount = ReferralSetting::get('referred_discount_amount', 100.00);
        $creditOnSignup = ReferralSetting::get('credit_on_signup', false);

        // Create referral record
        $referral = Referral::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $newUser->id,
            'referral_code' => $referralCode,
            'referrer_credit' => $referrerCredit,
            'referred_discount' => $referredDiscount,
            'credit_applied' => false,
            'discount_applied' => false,
        ]);

        // If credit_on_signup is true, immediately credit the referrer
        if ($creditOnSignup) {
            $this->creditReferrer($referral);
        }

        return $referral;
    }

    /**
     * Credit the referrer's wallet (User A gets credit).
     */
    public function creditReferrer(Referral $referral): void
    {
        if ($referral->credit_applied) {
            return;
        }

        try {
            DB::beginTransaction();

            $referrer = $referral->referrer;
            $wallet = $referrer->getOrCreateWallet();

            $this->walletService->credit(
                $wallet,
                $referral->referrer_credit,
                "Referral bonus - {$referral->referred->name} joined using your code",
                [
                    'referral_id' => $referral->id,
                    'referred_user_id' => $referral->referred_id,
                    'type' => 'referral_bonus',
                ],
                $referrer->id
            );

            $referral->markCreditApplied();

            DB::commit();

            Log::info("Referral credit applied: Referrer #{$referrer->id} received ₹{$referral->referrer_credit}");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to credit referrer: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Apply referral discount for referred user (User B uses discount).
     */
    public function applyReferralDiscount(User $user, ?int $enrollmentId = null): ?Referral
    {
        // Find pending referral discount for this user
        $referral = Referral::where('referred_id', $user->id)
            ->where('discount_applied', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$referral) {
            return null;
        }

        // Mark discount as applied
        $referral->markDiscountApplied($enrollmentId);

        // If credit wasn't applied on signup, apply it now (after first purchase)
        if (!$referral->credit_applied) {
            $this->creditReferrer($referral);
        }

        return $referral;
    }

    /**
     * Get available referral discount for a user.
     */
    public function getAvailableDiscount(User $user): ?Referral
    {
        return Referral::where('referred_id', $user->id)
            ->where('discount_applied', false)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Create referral code for a user if they don't have one.
     */
    public function getOrCreateReferralCode(User $user): ReferralCode
    {
        $existingCode = ReferralCode::where('user_id', $user->id)->first();

        if ($existingCode) {
            return $existingCode;
        }

        return ReferralCode::createForUser($user);
    }

    /**
     * Get referral statistics for a user.
     */
    public function getReferralStats(User $user): array
    {
        $totalReferrals = Referral::where('referrer_id', $user->id)->count();
        $pendingReferrals = Referral::where('referrer_id', $user->id)
            ->where('discount_applied', false)
            ->count();
        $completedReferrals = Referral::where('referrer_id', $user->id)
            ->where('discount_applied', true)
            ->count();
        $totalEarned = Referral::where('referrer_id', $user->id)
            ->where('credit_applied', true)
            ->sum('referrer_credit');

        return [
            'total_referrals' => $totalReferrals,
            'pending_referrals' => $pendingReferrals,
            'completed_referrals' => $completedReferrals,
            'total_earned' => $totalEarned,
        ];
    }

    /**
     * Get referral history for a user.
     */
    public function getReferralHistory(User $user, int $perPage = 10)
    {
        return Referral::where('referrer_id', $user->id)
            ->with('referred')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
