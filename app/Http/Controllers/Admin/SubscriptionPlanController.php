<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\TeacherEnquiry;
use App\Models\TeacherSubscription;
use App\Models\TeacherSubscriptionHistory;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    // Plans Management
    public function plansIndex()
    {
        $plans = SubscriptionPlan::orderBy('priority')->paginate(10);
        $stats = [
            'totalPlans' => SubscriptionPlan::count(),
            'activePlans' => SubscriptionPlan::active()->count(),
            'totalSubscriptions' => TeacherSubscription::where('status', 'active')->count(),
        ];

        return view('admin.subscriptions.plans.index', compact('plans', 'stats'));
    }

    public function plansCreate()
    {
        return view('admin.subscriptions.plans.create');
    }

    public function plansStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:subscription_plans|string',
            'slug' => 'required|unique:subscription_plans|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'features_list' => 'nullable|string',
            'max_students' => 'nullable|integer|min:0',
            'max_courses' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle features list conversion to JSON
        $features = null;
        if (!empty($validated['features_list'])) {
            $featuresArray = array_filter(array_map('trim', explode("\n", $validated['features_list'])));
            $features = json_encode(array_values($featuresArray));
        }

        // Remove features_list and prepare data for creation
        unset($validated['features_list']);
        $validated['features'] = $features;
        
        // Set default values for nullable fields (0 = unlimited)
        $validated['max_students'] = $validated['max_students'] ?? 0;
        $validated['max_courses'] = $validated['max_courses'] ?? 0;
        $validated['priority'] = $validated['priority'] ?? 0;

        $plan = SubscriptionPlan::create($validated);

        return redirect()->route('admin.subscriptions.plans.index')
                        ->with('success', 'Subscription plan created successfully!');
    }

    public function plansEdit(SubscriptionPlan $plan)
    {
        return view('admin.subscriptions.plans.edit', compact('plan'));
    }

    public function plansUpdate(Request $request, SubscriptionPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|unique:subscription_plans,name,' . $plan->id . '|string',
            'slug' => 'required|unique:subscription_plans,slug,' . $plan->id . '|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'features_list' => 'nullable|string',
            'max_students' => 'nullable|integer|min:0',
            'max_courses' => 'nullable|integer|min:0',
            'priority' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Handle features list conversion to JSON
        $features = null;
        if (!empty($validated['features_list'])) {
            $featuresArray = array_filter(array_map('trim', explode("\n", $validated['features_list'])));
            $features = json_encode(array_values($featuresArray));
        }

        // Remove features_list and prepare data for update
        unset($validated['features_list']);
        $validated['features'] = $features;
        
        // Set default values for nullable fields (0 = unlimited)
        $validated['max_students'] = $validated['max_students'] ?? 0;
        $validated['max_courses'] = $validated['max_courses'] ?? 0;
        $validated['priority'] = $validated['priority'] ?? 0;

        $plan->update($validated);

        return redirect()->route('admin.subscriptions.plans.index')
                        ->with('success', 'Subscription plan updated successfully!');
    }

    public function plansDestroy(SubscriptionPlan $plan)
    {
        // Check if plan has active subscriptions
        if ($plan->subscriptions()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete plan with active subscriptions!');
        }

        $plan->delete();

        return redirect()->route('admin.subscriptions.plans.index')
                        ->with('success', 'Subscription plan deleted successfully!');
    }

    // Enquiries Management
    public function enquiriesIndex()
    {
        $enquiries = TeacherEnquiry::latest()->paginate(15);
        $stats = [
            'pending' => TeacherEnquiry::pending()->count(),
            'approved' => TeacherEnquiry::approved()->count(),
            'rejected' => TeacherEnquiry::rejected()->count(),
        ];

        return view('admin.subscriptions.enquiries.index', compact('enquiries', 'stats'));
    }

    public function enquiriesShow(TeacherEnquiry $enquiry)
    {
        return view('admin.subscriptions.enquiries.show', compact('enquiry'));
    }

    public function enquiriesApprove(Request $request, TeacherEnquiry $enquiry)
    {
        $enquiry->approve(auth()->id());

        // Create subscription
        $subscription = TeacherSubscription::create([
            'user_id' => $enquiry->user_id ?? null,
            'plan_id' => $enquiry->plan_id,
            'teacher_enquiry_id' => $enquiry->id,
            'started_at' => now(),
            'expires_at' => now()->addYear(),
            'status' => 'active',
            'paid_amount' => $enquiry->plan->price,
        ]);

        // Log history
        TeacherSubscriptionHistory::create([
            'user_id' => $subscription->user_id,
            'to_plan_id' => $enquiry->plan_id,
            'action' => 'created',
            'amount_paid' => $enquiry->plan->price,
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Enquiry approved and subscription created!');
    }

    public function enquiriesReject(Request $request, TeacherEnquiry $enquiry)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        $enquiry->reject($validated['rejection_reason'], auth()->id());

        return back()->with('success', 'Enquiry rejected successfully!');
    }

    // Subscriptions Management
    public function subscriptionsIndex()
    {
        $plans = SubscriptionPlan::orderBy('priority')->paginate(10);
        $stats = [
            'totalPlans' => SubscriptionPlan::count(),
            'activePlans' => SubscriptionPlan::active()->count(),
            'totalSubscriptions' => TeacherSubscription::where('status', 'active')->count(),
        ];

        return view('admin.subscriptions.plans.index', compact('plans', 'stats'));
    }

    public function subscriptionsShow(TeacherSubscription $subscription)
    {
        $plans = SubscriptionPlan::orderBy('priority')->paginate(10);
        $stats = [
            'totalPlans' => SubscriptionPlan::count(),
            'activePlans' => SubscriptionPlan::active()->count(),
            'totalSubscriptions' => TeacherSubscription::where('status', 'active')->count(),
        ];
        return view('admin.subscriptions.plans.index', compact('plans', 'stats'));
    }

    // History Management
    public function historyIndex()
    {
        $history = TeacherSubscriptionHistory::with(['user', 'fromPlan', 'toPlan'])
                                           ->latest()
                                           ->paginate(20);

        return view('admin.subscriptions.history.index', compact('history'));
    }
}
