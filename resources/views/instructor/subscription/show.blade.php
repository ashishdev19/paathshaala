<x-layouts.instructor>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                <i class="fas fa-crown text-indigo-600"></i> Subscription Management
            </h2>
            <a href="{{ route('instructor.dashboard') }}" class="px-4 py-2 border border-indigo-200 rounded-lg text-indigo-700 hover:bg-indigo-50 transition duration-200">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Flash Messages -->
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif
        
        @if (session('warning'))
            <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-lg">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
            </div>
        @endif
        
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Current Subscription & History (Left - 2 columns) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Subscription Card -->
                <div class="bg-white rounded-lg shadow-lg border border-indigo-100">
                    <div class="border-b border-indigo-100 px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <h5 class="text-lg font-semibold flex items-center text-indigo-900">
                            <i class="fas fa-user-check mr-2 text-indigo-600"></i> Current Subscription
                        </h5>
                    </div>
                    <div class="p-6">
                        @if($currentSubscription)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Plan Details -->
                                <div>
                                    <h4 class="text-2xl font-bold text-indigo-600 mb-2">{{ $currentSubscription->plan->name }}</h4>
                                    <p class="text-gray-600 mb-4">{{ $currentSubscription->plan->description ?? 'Premium subscription plan' }}</p>
                                    
                                    <div class="space-y-3 mb-4">
                                        <div>
                                            <strong>Status:</strong>
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'expired' => 'bg-red-100 text-red-800',
                                                    'cancelled' => 'bg-yellow-100 text-yellow-800'
                                                ];
                                            @endphp
                                            <span class="inline-block ml-2 px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$currentSubscription->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($currentSubscription->status) }}
                                            </span>
                                        </div>
                                        
                                        <div>
                                            <strong>Started:</strong> {{ $currentSubscription->started_at->format('M d, Y') }}
                                        </div>
                                        
                                        <div>
                                            <strong>Next Billing:</strong> 
                                            @if($currentSubscription->status == 'active')
                                                <span class="text-green-600 font-semibold">{{ $currentSubscription->expires_at->format('M d, Y') }}</span>
                                            @else
                                                <span class="text-gray-500">N/A</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Pricing Info -->
                                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 border border-indigo-200">
                                    <div class="text-center mb-4">
                                        <span class="text-4xl font-bold text-indigo-600">₹{{ number_format($currentSubscription->plan->price, 0) }}</span>
                                        <small class="block text-gray-600">/month</small>
                                        @if($currentSubscription->plan->price)
                                            <div class="text-sm text-gray-500 mt-2">
                                                or ₹{{ number_format($currentSubscription->plan->price * 12, 0) }}/year
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <ul class="space-y-2">
                                        @php
                                            $features = is_string($currentSubscription->plan->features) 
                                                ? json_decode($currentSubscription->plan->features, true) ?? []
                                                : (is_array($currentSubscription->plan->features) ? $currentSubscription->plan->features : []);
                                        @endphp
                                        
                                        @if($currentSubscription->plan->max_courses)
                                            <li class="flex items-center text-sm">
                                                <i class="fas fa-check text-green-600 mr-2"></i>
                                                {{ $currentSubscription->plan->max_courses }} Courses Max
                                            </li>
                                        @else
                                            <li class="flex items-center text-sm">
                                                <i class="fas fa-infinity text-green-600 mr-2"></i>
                                                Unlimited Courses
                                            </li>
                                        @endif
                                        
                                        @if($currentSubscription->plan->max_students)
                                            <li class="flex items-center text-sm">
                                                <i class="fas fa-check text-green-600 mr-2"></i>
                                                {{ $currentSubscription->plan->max_students }} Students Max
                                            </li>
                                        @else
                                            <li class="flex items-center text-sm">
                                                <i class="fas fa-users text-green-600 mr-2"></i>
                                                Unlimited Students
                                            </li>
                                        @endif
                                        
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-check text-green-600 mr-2"></i>
                                            40% Platform Commission
                                        </li>
                                        
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-check text-green-600 mr-2"></i>
                                            Basic Listing
                                        </li>
                                        
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-check text-green-600 mr-2"></i>
                                            Limited Support
                                        </li>
                                        
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-check text-green-600 mr-2"></i>
                                            Standard Search Visibility
                                        </li>
                                        
                                        <li class="flex items-center text-sm">
                                            <i class="fas fa-check text-green-600 mr-2"></i>
                                            Basic Analytics
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2 justify-end mt-6 pt-6 border-t">
                                @if($currentSubscription->status == 'active')
                                    <button onclick="cancelSubscription()" class="px-4 py-2 border-2 border-yellow-500 text-yellow-600 rounded-lg hover:bg-yellow-50 transition duration-200">
                                        <i class="fas fa-times mr-1"></i> Cancel Subscription
                                    </button>
                                @endif
                                
                                <a href="{{ route('instructor.subscription.upgrade') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-arrow-up mr-1"></i> Upgrade Plan
                                </a>
                            </div>
                        @else
                            <!-- No Subscription -->
                            <div class="text-center py-12">
                                <i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4"></i>
                                <h5 class="text-xl font-semibold mb-2">No Active Subscription</h5>
                                <p class="text-gray-600 mb-6">You need an active subscription to create and manage courses.</p>
                                <a href="{{ route('instructor.subscription.upgrade') }}" class="inline-block px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-plus mr-1"></i> Choose a Plan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Subscription History -->
                <div class="bg-white rounded-lg shadow-lg border border-indigo-100">
                    <div class="border-b border-indigo-100 px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <h5 class="text-lg font-semibold flex items-center text-indigo-900">
                            <i class="fas fa-history mr-2 text-indigo-600"></i> Subscription History
                        </h5>
                    </div>
                    <div class="p-6">
                        @if($subscriptionHistory && $subscriptionHistory->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-200">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-semibold text-indigo-900">Plan</th>
                                            <th class="px-4 py-3 text-left font-semibold text-indigo-900">Status</th>
                                            <th class="px-4 py-3 text-left font-semibold text-indigo-900">Started</th>
                                            <th class="px-4 py-3 text-left font-semibold text-indigo-900">Ended</th>
                                            <th class="px-4 py-3 text-left font-semibold text-indigo-900">Duration</th>
                                            <th class="px-4 py-3 text-left font-semibold text-indigo-900">Total Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        @foreach($subscriptionHistory as $sub)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3">
                                                    <strong>{{ $sub->plan->name ?? 'N/A' }}</strong>
                                                </td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $statusColors = [
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'expired' => 'bg-red-100 text-red-800',
                                                            'upgraded' => 'bg-blue-100 text-blue-800',
                                                            'cancelled' => 'bg-yellow-100 text-yellow-800'
                                                        ];
                                    $action = $sub->action ?? 'active';
                                                    @endphp
                                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$action] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($action) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3">{{ $sub->created_at->format('M d, Y') }}</td>
                                                <td class="px-4 py-3">
                                                    @if($sub->to_plan_id)
                                                        @php
                                                            $toPlan = \App\Models\SubscriptionPlan::find($sub->to_plan_id);
                                                        @endphp
                                                        {{ $toPlan ? $toPlan->name : 'N/A' }}
                                                    @else
                                                        <span class="text-gray-500">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-3">
                                                    Ongoing
                                                </td>
                                                <td class="px-4 py-3 text-green-600 font-semibold">₹{{ number_format($sub->amount_paid ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-3"></i>
                                <h6 class="text-gray-500">No subscription history</h6>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Available Plans (Right - 1 column) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg border border-indigo-100 sticky top-6">
                    <div class="border-b border-indigo-100 px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50">
                        <h5 class="text-lg font-semibold flex items-center text-indigo-900">
                            <i class="fas fa-list-alt mr-2 text-indigo-600"></i> Available Plans
                        </h5>
                    </div>
                    <div class="p-6 space-y-3">
                        @foreach($availablePlans as $plan)
                            <div class="border rounded-lg p-4 {{ $currentSubscription && $currentSubscription->plan_id == $plan->id ? 'border-2 border-indigo-600 bg-gradient-to-br from-indigo-50 to-purple-50' : 'border-indigo-100 hover:border-indigo-300 hover:shadow-lg' }} transition duration-300">
                                <div class="flex justify-between items-start mb-2">
                                    <h6 class="font-semibold text-gray-800">{{ $plan->name }}</h6>
                                    @if($currentSubscription && $currentSubscription->plan_id == $plan->id)
                                        <span class="inline-block px-2 py-1 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs rounded-full font-semibold shadow-md">Current</span>
                                    @endif
                                </div>
                                
                                <div class="text-center mb-3">
                                    <div class="text-2xl font-bold text-indigo-600">₹{{ number_format($plan->price, 0) }}</div>
                                    <small class="text-gray-600">/month</small>
                                    <div class="text-xs text-gray-500 mt-1">
                                        or ₹{{ number_format($plan->price * 12, 0) }}/year
                                    </div>
                                </div>
                                
                                <p class="text-xs text-gray-600 mb-3">{{ $plan->description ?? 'Premium plan' }}</p>
                                
                                <ul class="text-xs space-y-1 mb-4">
                                    @if($plan->max_courses)
                                        <li class="flex items-center">
                                            <i class="fas fa-check text-green-600 mr-1"></i>
                                            <span>Max {{ $plan->max_courses }} Courses</span>
                                        </li>
                                    @else
                                        <li class="flex items-center">
                                            <i class="fas fa-infinity text-green-600 mr-1"></i>
                                            <span>Unlimited Courses</span>
                                        </li>
                                    @endif
                                    
                                    @if($plan->max_students)
                                        <li class="flex items-center">
                                            <i class="fas fa-check text-green-600 mr-1"></i>
                                            <span>Max {{ $plan->max_students }} Students</span>
                                        </li>
                                    @else
                                        <li class="flex items-center">
                                            <i class="fas fa-infinity text-green-600 mr-1"></i>
                                            <span>Unlimited Students</span>
                                        </li>
                                    @endif
                                </ul>
                                
                                @if(!$currentSubscription || $currentSubscription->plan_id != $plan->id)
                                    <div class="w-full">
                                        <a href="{{ route('instructor.subscription.payment', ['plan' => $plan->id]) }}" 
                                           class="block w-full text-center px-3 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 text-sm font-semibold transition duration-200 shadow-md hover:shadow-lg">
                                            @if($currentSubscription && $plan->price > $currentSubscription->plan->price)
                                                Upgrade to {{ $plan->name }}
                                            @elseif($currentSubscription)
                                                Switch to {{ $plan->name }}
                                            @else
                                                Select Plan
                                            @endif
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function cancelSubscription() {
            if (confirm('Are you sure you want to cancel your subscription? You will no longer be able to create new courses.')) {
                // TODO: Implement subscription cancellation via API/form
                alert('Subscription cancellation feature coming soon!');
            }
        }
    </script>
</x-layouts.instructor>
