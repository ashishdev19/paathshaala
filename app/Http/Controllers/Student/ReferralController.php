<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    protected ReferralService $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Display student referral dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get or create referral code for user
        $referralCode = $this->referralService->getOrCreateReferralCode($user);
        
        // Get referral statistics
        $stats = $this->referralService->getReferralStats($user);
        
        // Get referral history with pagination
        $referrals = $this->referralService->getReferralHistory($user, 10);
        
        // Get pending discount if user was referred
        $pendingDiscount = $user->getPendingReferralDiscount();
        
        // Get wallet balance
        $wallet = $user->getOrCreateWallet();
        
        // Generate shareable link
        $shareableLink = route('register') . '?ref=' . $referralCode->code;
        
        return view('student.referral.index', compact(
            'referralCode',
            'stats',
            'referrals',
            'pendingDiscount',
            'shareableLink',
            'wallet'
        ));
    }
}
