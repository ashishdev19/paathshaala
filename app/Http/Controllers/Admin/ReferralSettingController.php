<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use App\Models\ReferralSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralSettingController extends Controller
{
    /**
     * Display referral settings and statistics.
     */
    public function index()
    {
        $settings = ReferralSetting::all()->keyBy('key');
        
        // Get referral statistics
        $stats = [
            'total_referrals' => Referral::count(),
            'pending_referrals' => Referral::where('discount_applied', false)->count(),
            'completed_referrals' => Referral::where('discount_applied', true)->count(),
            'total_credits_given' => Referral::where('credit_applied', true)->sum('referrer_credit'),
            'total_discounts_given' => Referral::where('discount_applied', true)->sum('referred_discount'),
        ];
        
        // Get recent referrals
        $recentReferrals = Referral::with(['referrer', 'referred'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.referral.settings', compact('settings', 'stats', 'recentReferrals'));
    }

    /**
     * Update referral settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'referrer_credit_amount' => 'required|numeric|min:0',
            'referred_discount_amount' => 'required|numeric|min:0',
            'credit_on_signup' => 'required|boolean',
            'referral_enabled' => 'required|boolean',
            'campaign_name' => 'nullable|string|max:255',
            'campaign_valid_from' => 'nullable|date',
            'campaign_valid_until' => 'nullable|date|after_or_equal:campaign_valid_from',
        ]);

        DB::beginTransaction();
        try {
            ReferralSetting::set('referrer_credit_amount', $request->referrer_credit_amount);
            ReferralSetting::set('referred_discount_amount', $request->referred_discount_amount);
            ReferralSetting::set('credit_on_signup', $request->credit_on_signup ? 'true' : 'false');
            ReferralSetting::set('referral_enabled', $request->referral_enabled ? 'true' : 'false');
            
            // Save campaign settings if provided
            if ($request->filled('campaign_name')) {
                ReferralSetting::set('campaign_name', $request->campaign_name);
            }
            if ($request->filled('campaign_valid_from')) {
                ReferralSetting::set('campaign_valid_from', $request->campaign_valid_from);
            }
            if ($request->filled('campaign_valid_until')) {
                ReferralSetting::set('campaign_valid_until', $request->campaign_valid_until);
            }

            DB::commit();

            return redirect()->route('admin.referral.settings')
                ->with('success', 'Referral settings updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Display all referrals.
     */
    public function referrals()
    {
        $referrals = Referral::with(['referrer', 'referred', 'enrollment'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.referral.list', compact('referrals'));
    }
}
