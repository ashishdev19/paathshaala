<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            @if(isset($isInitialSubscription) && $isInitialSubscription)
                Choose Your Plan
            @else
                Upgrade Your Plan
            @endif
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg border border-indigo-100 p-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 text-blue-700 rounded">{{ session('info') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        @if(isset($isInitialSubscription) && $isInitialSubscription)
            <div class="mb-6 p-4 bg-indigo-50 border border-indigo-200 rounded-lg">
                <p class="text-sm text-indigo-700">Select a plan to start creating courses and unlock all features.</p>
            </div>
        @elseif($currentSubscription)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Your Current Plan</h3>
                <p class="text-sm text-gray-700">
                    <strong>{{ $currentSubscription->plan->name }}</strong> 
                    — Expires: {{ $currentSubscription->expires_at->format('Y-m-d') }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($availablePlans as $plan)
                <div class="p-4 border border-indigo-100 rounded-lg hover:shadow-xl hover:border-indigo-300 transition duration-300">
                    @if($currentSubscription && $currentSubscription->plan_id === $plan->id)
                        <div class="mb-2 px-2 py-1 bg-indigo-100 text-indigo-700 text-xs rounded-full font-semibold">Current Plan</div>
                    @endif
                    <h4 class="font-semibold text-lg">{{ $plan->name }}</h4>
                    <p class="text-sm text-gray-600 mt-1">₹{{ number_format($plan->price, 2) }} / year</p>
                    <p class="text-xs text-gray-500 mt-2">{{ $plan->description ?? 'Premium features included' }}</p>
                    <ul class="text-xs text-gray-600 mt-3 space-y-1">
                        @if($plan->max_courses)
                            <li>✓ Max {{ $plan->max_courses }} Courses</li>
                        @else
                            <li>✓ Unlimited Courses</li>
                        @endif
                        @if($plan->max_students)
                            <li>✓ Max {{ $plan->max_students }} Students</li>
                        @else
                            <li>✓ Unlimited Students</li>
                        @endif
                    </ul>
                    
                    <div class="mt-4">
                        @if($currentSubscription && $currentSubscription->plan_id === $plan->id)
                            <button disabled class="w-full bg-indigo-200 text-indigo-700 px-3 py-2 rounded-lg text-sm font-semibold cursor-not-allowed">Current Plan</button>
                        @else
                            <form action="{{ route('instructor.subscription.process-upgrade') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-2 rounded-lg text-sm font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                                    @if(isset($isInitialSubscription) && $isInitialSubscription)
                                        Subscribe Now
                                    @else
                                        Upgrade
                                    @endif
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('instructor.subscription.show') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold hover:underline transition duration-200">Back to Subscription</a>
        </div>
    </div>
</x-layouts.instructor>
