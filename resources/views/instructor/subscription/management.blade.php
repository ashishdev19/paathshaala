<x-layouts.instructor>
    <!-- Version: 2.0 - Updated {{ now() }} -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        .subscription-container {
            background: #F8F9FB;
            min-height: 100vh;
        }
        
        .premium-card {
            background: white;
            border: 1px solid #EFF0F2;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .premium-card:hover {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .plan-card {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .plan-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(79, 70, 229, 0.15);
        }
        
        .plan-card.current-plan {
            border: 2px solid #4F46E5;
        }
        
        .badge-premium {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .badge-gold {
            background: linear-gradient(135deg, #F2C94C 0%, #F59E0B 100%);
        }
        
        .badge-silver {
            background: linear-gradient(135deg, #C0C0C0 0%, #9CA3AF 100%);
        }
        
        .current-plan-gradient {
            background: linear-gradient(135deg, #EEF2FF 0%, #E0E7FF 100%);
        }
        
        .btn-primary {
            background: #4F46E5;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }
        
        .btn-primary:hover {
            background: #4338CA;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }
        
        .btn-outline {
            border: 2px solid #EFF0F2;
            color: #1F2937;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
        }
        
        .btn-outline:hover {
            border-color: #4F46E5;
            color: #4F46E5;
            background: #EEF2FF;
        }
        
        .feature-icon {
            width: 40px;
            height: 40px;
            background: #EEF2FF;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4F46E5;
        }
        
        .price-tag {
            font-size: 36px;
            font-weight: 700;
            color: #1F2937;
            line-height: 1;
        }
        
        .table-modern {
            border-collapse: separate;
            border-spacing: 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .table-modern thead {
            background: #F8F9FB;
        }
        
        .table-modern tbody tr {
            transition: all 0.2s ease;
        }
        
        .table-modern tbody tr:hover {
            background: #F8F9FB;
        }
        
        .table-modern tbody tr:nth-child(even) {
            background: #FAFBFC;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-active {
            background: #D1FAE5;
            color: #065F46;
        }
        
        .status-expired {
            background: #FEE2E2;
            color: #991B1B;
        }
        
        .status-cancelled {
            background: #FEF3C7;
            color: #92400E;
        }
        
        .renewal-tag {
            background: #EEF2FF;
            border: 1px solid #C7D2FE;
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #4F46E5;
            font-size: 14px;
            font-weight: 500;
        }
    </style>

    <div class="subscription-container py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Subscription Management</h1>
                    <p class="text-gray-600">Manage your subscription plan and billing</p>
                </div>
                <a href="{{ route('instructor.dashboard') }}" class="btn-outline inline-flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            @if(session('success'))
                <div class="premium-card p-4 mb-6 bg-green-50 border-green-200">
                    <div class="flex items-center gap-3 text-green-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="premium-card p-4 mb-6 bg-red-50 border-red-200">
                    <div class="flex items-center gap-3 text-red-800">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Current Subscription & History (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Subscription Card -->
                @if($currentSubscription)
                    <div class="premium-card current-plan-gradient p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $currentSubscription->plan->name }}</h2>
                                    <span class="badge-premium">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                        Current Plan
                                    </span>
                                </div>
                                <p class="text-gray-600">{{ $currentSubscription->plan->description ?? 'Premium subscription plan' }}</p>
                            </div>
                            <div class="text-right">
                                <div class="price-tag">₹{{ number_format($currentSubscription->plan->price) }}</div>
                                <p class="text-gray-500 text-sm mt-1">per {{ $currentSubscription->plan->duration_value }} {{ $currentSubscription->plan->duration_type }}</p>
                            </div>
                        </div>

                        <!-- Plan Features -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="flex items-start gap-3">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Courses Limit</p>
                                    <p class="text-gray-600 text-sm">{{ $currentSubscription->plan->course_limit == -1 ? 'Unlimited' : $currentSubscription->plan->course_limit }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Students Limit</p>
                                    <p class="text-gray-600 text-sm">{{ $currentSubscription->plan->student_limit == -1 ? 'Unlimited' : $currentSubscription->plan->student_limit }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="feature-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">Features</p>
                                    <p class="text-gray-600 text-sm">{{ count($currentSubscription->plan->features ?? []) }} Included</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status & Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-indigo-200">
                            <div class="flex items-center gap-4">
                                @php
                                    $statusColors = [
                                        'active' => 'status-active',
                                        'expired' => 'status-expired',
                                        'cancelled' => 'status-cancelled'
                                    ];
                                @endphp
                                <span class="status-badge {{ $statusColors[$currentSubscription->status] ?? 'status-active' }}">
                                    <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                    </svg>
                                    {{ ucfirst($currentSubscription->status) }}
                                </span>
                                <div class="renewal-tag">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Started {{ $currentSubscription->started_at->format('M d, Y') }}
                                </div>
                            </div>
                            <div class="text-right">
                                @if($currentSubscription->status == 'active')
                                    <p class="text-sm text-gray-600">Expires on</p>
                                    <p class="font-semibold text-gray-900">{{ $currentSubscription->expires_at->format('M d, Y') }}</p>
                                @else
                                    <p class="text-sm text-gray-600">Subscription Ended</p>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        @if($currentSubscription->status == 'active')
                            <div class="flex gap-3 mt-6">
                                <button onclick="cancelSubscription()" class="btn-outline inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel Subscription
                                </button>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="premium-card p-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">No Active Subscription</h3>
                        <p class="text-gray-600 mb-6">Choose a plan to start creating courses and growing your teaching business</p>
                        <a href="#plans" class="btn-primary inline-block">Browse Plans</a>
                    </div>
                @endif

                <!-- Subscription History -->
                <div class="premium-card p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Subscription History</h3>
                            <p class="text-gray-600 text-sm">View all your past subscriptions and transactions</p>
                        </div>
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>

                    @if($subscriptionHistory && $subscriptionHistory->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table-modern w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Plan</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Started</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ended/Expired</th>
                                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subscriptionHistory as $sub)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-gray-900">{{ $sub->plan->name ?? 'N/A' }}</p>
                                                        <p class="text-xs text-gray-500">{{ $sub->plan->description ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @php
                                                    $statusMap = [
                                                        'active' => 'status-active',
                                                        'expired' => 'status-expired',
                                                        'upgraded' => 'status-active',
                                                        'cancelled' => 'status-cancelled'
                                                    ];
                                                @endphp
                                                <span class="status-badge {{ $statusMap[$sub->action] ?? 'status-active' }}">
                                                    {{ ucfirst($sub->action ?? 'N/A') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-gray-700">
                                                {{ $sub->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-700">
                                                @if($sub->to_plan && $sub->to_plan_id)
                                                    @php
                                                        $toPlan = \App\Models\SubscriptionPlan::find($sub->to_plan_id);
                                                    @endphp
                                                    {{ $toPlan ? $toPlan->name : 'N/A' }}
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="font-semibold text-gray-900">₹{{ number_format($sub->amount_paid ?? 0, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500">No subscription history available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Available Plans (Right - 1 column) -->
            <div class="lg:col-span-1">
                <div class="sticky top-8">
                    <div class="premium-card p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-gray-900">Available Plans</h3>
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>

                        <div class="space-y-4" id="plans">
                            @foreach($availablePlans as $index => $plan)
                                <div class="plan-card premium-card p-5 {{ $currentSubscription && $currentSubscription->plan_id == $plan->id ? 'current-plan' : '' }}">
                                    <!-- Plan Header -->
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-bold text-gray-900">{{ $plan->name }}</h4>
                                                @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                                                    <span class="badge-premium text-xs">Active</span>
                                                @elseif($index == 0)
                                                    <span class="badge-gold text-xs">Popular</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-600">{{ $plan->description ?? 'Premium plan' }}</p>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-4 pb-4 border-b border-gray-100">
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-bold text-gray-900">₹{{ number_format($plan->price, 0) }}</span>
                                            <span class="text-sm text-gray-500">/{{ $plan->duration_value ?? '1' }} {{ $plan->duration_type ?? 'year' }}</span>
                                        </div>
                                    </div>

                                    <!-- Features -->
                                    <ul class="space-y-2 mb-4">
                                        @if($plan->course_limit ?? $plan->max_courses)
                                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                                </svg>
                                                @if(($plan->course_limit ?? $plan->max_courses) == -1)
                                                    <span>Unlimited Courses</span>
                                                @else
                                                    <span>Up to {{ $plan->course_limit ?? $plan->max_courses }} Courses</span>
                                                @endif
                                            </li>
                                        @endif
                                        
                                        @if($plan->student_limit ?? $plan->max_students)
                                            <li class="flex items-center gap-2 text-sm text-gray-700">
                                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                                </svg>
                                                @if(($plan->student_limit ?? $plan->max_students) == -1)
                                                    <span>Unlimited Students</span>
                                                @else
                                                    <span>{{ $plan->student_limit ?? $plan->max_students }} Students</span>
                                                @endif
                                            </li>
                                        @endif
                                        
                                        <li class="flex items-center gap-2 text-sm text-gray-700">
                                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                            </svg>
                                            <span>Priority Support</span>
                                        </li>
                                    </ul>

                                    <!-- Action Button -->
                                    @if(!$currentSubscription || $currentSubscription->plan_id != $plan->id)
                                        <a href="{{ route('instructor.subscription.payment', ['plan' => $plan->id]) }}" 
                                           class="btn-primary w-full text-center inline-flex items-center justify-center gap-2">
                                            @if($currentSubscription && $plan->price > $currentSubscription->plan->price)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                                </svg>
                                                Upgrade Plan
                                            @elseif($currentSubscription)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                </svg>
                                                Switch Plan
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Select Plan
                                            @endif
                                        </a>
                                    @else
                                        <div class="text-center py-3 bg-indigo-50 rounded-lg">
                                            <span class="text-indigo-600 font-semibold text-sm">Your Current Plan</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Help Card -->
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 mb-1">Need Help?</p>
                                    <p class="text-xs text-gray-600 mb-2">Contact support for custom plans or questions</p>
                                    <a href="#" class="text-xs text-indigo-600 font-semibold hover:text-indigo-700">Contact Support →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.instructor>

<script>
    function cancelSubscription() {
        if (confirm('Are you sure you want to cancel your subscription? You will lose access to premium features.')) {
            // TODO: Implement subscription cancellation
            alert('Subscription cancellation feature coming soon!');
        }
    }
</script>
