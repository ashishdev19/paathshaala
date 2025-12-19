<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\TeacherSubscription;
use App\Models\TeacherSubscriptionHistory;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show current subscription status
    public function show()
    {
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;
        $subscriptionHistory = $user->subscriptionHistory()->latest()->limit(10)->get();
        $availablePlans = SubscriptionPlan::active()->orderBy('priority')->get();

        return view('instructor.subscription.show', compact('currentSubscription', 'subscriptionHistory', 'availablePlans'));
    }

    // Show subscription management dashboard
    public function management()
    {
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;
        $subscriptionHistory = $user->subscriptionHistory()->latest()->get();
        $availablePlans = SubscriptionPlan::active()->orderBy('priority')->get();

        return view('instructor.subscription.management', compact('currentSubscription', 'subscriptionHistory', 'availablePlans'));
    }

    // Show upgrade options
    public function upgrade()
    {
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription) {
            // No active subscription, show all available plans for initial subscription
            $availablePlans = SubscriptionPlan::active()->orderBy('priority')->get();
            return view('instructor.subscription.upgrade', ['currentSubscription' => null, 'availablePlans' => $availablePlans, 'isInitialSubscription' => true]);
        }

        // Has active subscription, show upgrade options (higher tier plans only)
        $availablePlans = SubscriptionPlan::active()
                                         ->where('price', '>', $currentSubscription->plan->price)
                                         ->orderBy('price')
                                         ->get();

        if ($availablePlans->isEmpty()) {
            return back()->with('info', 'No higher tier plans available for upgrade.');
        }

        return view('instructor.subscription.upgrade', compact('currentSubscription', 'availablePlans'));
    }

    // Process subscription upgrade - redirect to payment
    public function processUpgrade(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $user = auth()->user();
        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
        $currentSubscription = $user->currentSubscription;
        
        // Calculate amount to charge
        $amount = $plan->price;
        if ($currentSubscription && $currentSubscription->canUpgradeTo($plan)) {
            $amount = $currentSubscription->getUpgradeCost($plan);
        } elseif ($currentSubscription && !$currentSubscription->canUpgradeTo($plan)) {
            return back()->with('error', 'Cannot downgrade to this plan.');
        }

        // Store subscription plan preference in session for payment processing
        session([
            'subscription_plan_id' => $plan->id,
            'subscription_amount' => $amount,
            'current_subscription_id' => $currentSubscription ? $currentSubscription->id : null,
        ]);

        // Redirect to subscription payment page
        return redirect()->route('instructor.subscription.payment', ['plan' => $plan->id]);
    }

    // Show payment page for subscription
    public function paymentPage($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;
        
        // Calculate amount
        $amount = $plan->price;
        if ($currentSubscription && $currentSubscription->canUpgradeTo($plan)) {
            $amount = $currentSubscription->getUpgradeCost($plan);
        }

        return view('instructor.subscription.payment', compact('plan', 'amount', 'currentSubscription'));
    }

    // Process subscription payment - initiate Razorpay
    public function processPayment(Request $request, $planId)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:razorpay,card,upi,netbanking',
        ]);

        $user = auth()->user();
        $plan = SubscriptionPlan::findOrFail($planId);
        $currentSubscription = $user->currentSubscription;
        
        // Calculate amount
        $amount = $plan->price;
        $isUpgrade = false;
        if ($currentSubscription && $currentSubscription->canUpgradeTo($plan)) {
            $amount = $currentSubscription->getUpgradeCost($plan);
            $isUpgrade = true;
        }

        // TODO: Integrate with Razorpay payment gateway
        // For now, redirect to a pending payment page with Razorpay integration instructions
        session([
            'pending_subscription_plan_id' => $plan->id,
            'pending_subscription_amount' => $amount,
            'pending_subscription_is_upgrade' => $isUpgrade,
            'pending_payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('instructor.subscription.payment-pending', ['plan' => $plan->id]);
    }

    // Show payment processing page (Razorpay integration point)
    public function paymentPending($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        $user = auth()->user();
        
        $amount = session('pending_subscription_amount');
        if (!$amount) {
            return redirect()->route('instructor.subscription.upgrade')
                           ->with('error', 'Invalid payment session. Please try again.');
        }

        return view('instructor.subscription.payment-pending', [
            'plan' => $plan,
            'amount' => $amount,
            'user' => $user,
            'paymentMethod' => session('pending_payment_method'),
        ]);
    }

    // Handle successful payment callback
    public function paymentSuccess(Request $request, $planId)
    {
        $user = auth()->user();
        $plan = SubscriptionPlan::findOrFail($planId);
        $currentSubscription = $user->currentSubscription;
        
        // Retrieve pending payment session data
        $amount = session('pending_subscription_amount');
        $isUpgrade = session('pending_subscription_is_upgrade');
        
        if (!$amount) {
            return redirect()->route('instructor.subscription.upgrade')
                           ->with('error', 'Payment session expired. Please try again.');
        }

        // Create/upgrade subscription after successful payment
        if ($currentSubscription && $isUpgrade) {
            // Upgrade existing subscription
            TeacherSubscriptionHistory::create([
                'user_id' => $user->id,
                'from_plan_id' => $currentSubscription->plan_id,
                'to_plan_id' => $plan->id,
                'action' => 'upgraded',
                'amount_paid' => $amount,
            ]);
            $currentSubscription->upgradeTo($plan, $amount);
        } else {
            // Create new subscription
            $subscription = TeacherSubscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'started_at' => now(),
                'expires_at' => now()->addYear(),
                'status' => 'active',
                'paid_amount' => $amount,
            ]);
            
            TeacherSubscriptionHistory::create([
                'user_id' => $user->id,
                'to_plan_id' => $plan->id,
                'action' => 'created',
                'amount_paid' => $amount,
            ]);
        }

        // Clear pending payment session
        session()->forget(['pending_subscription_plan_id', 'pending_subscription_amount', 'pending_subscription_is_upgrade', 'pending_payment_method']);

        return redirect()->route('instructor.subscription.show')
                       ->with('success', "Successfully subscribed to {$plan->name}! Amount: ₹{$amount}");
    }

    // Handle payment failure
    public function paymentFailed($planId)
    {
        // Clear pending payment session
        session()->forget(['pending_subscription_plan_id', 'pending_subscription_amount', 'pending_subscription_is_upgrade', 'pending_payment_method']);

        return redirect()->route('instructor.subscription.payment', ['plan' => $planId])
                       ->with('error', 'Payment failed. Please try again with a different payment method.');
    }

    // Show renewal options
    public function renew()
    {
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription || !$currentSubscription->isExpired()) {
            return redirect()->route('instructor.subscription.show')
                           ->with('info', 'Your subscription is still active.');
        }

        return view('instructor.subscription.renew', compact('currentSubscription'));
    }

    // Process subscription renewal
    public function processRenew(Request $request)
    {
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription) {
            return back()->with('error', 'No subscription found.');
        }

        $renewalCost = $currentSubscription->plan->price;

        // Log renewal history
        TeacherSubscriptionHistory::create([
            'user_id' => $user->id,
            'to_plan_id' => $currentSubscription->plan_id,
            'action' => 'renewed',
            'amount_paid' => $renewalCost,
        ]);

        // Renew subscription
        $currentSubscription->renew($renewalCost);

        return redirect()->route('instructor.subscription.show')
                       ->with('success', 'Subscription renewed successfully for another year!');
    }

    // Cancel subscription
    public function cancel(Request $request)
    {
        $validated = $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription) {
            return back()->with('error', 'No active subscription found.');
        }

        // Log cancellation
        TeacherSubscriptionHistory::create([
            'user_id' => $user->id,
            'from_plan_id' => $currentSubscription->plan_id,
            'action' => 'cancelled',
            'notes' => $validated['reason'],
        ]);

        // Cancel subscription
        $currentSubscription->cancel($validated['reason']);

        return redirect()->route('instructor.subscription.show')
                       ->with('success', 'Subscription cancelled successfully.');
    }

    // Download subscription certificate
    public function downloadCertificate()
    {
        $user = auth()->user();
        $currentSubscription = $user->currentSubscription;

        if (!$currentSubscription || !$currentSubscription->isActive()) {
            return back()->with('error', 'No active subscription found.');
        }

        // TODO: Generate and download certificate
        return back()->with('info', 'Certificate feature coming soon!');
    }
}
