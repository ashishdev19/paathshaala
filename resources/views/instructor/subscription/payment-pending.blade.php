<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Complete Payment</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg border border-indigo-100 p-6">
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <div class="mb-6 p-4 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-lg">
            <h3 class="text-lg font-semibold text-indigo-900 mb-2">Payment Processing</h3>
            <p class="text-sm text-indigo-700">You will be redirected to the payment gateway. Please complete the payment to activate your subscription.</p>
        </div>

        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Order Details</h3>
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 space-y-3 border border-indigo-200">
                <div class="flex justify-between">
                    <span class="text-gray-600">Plan</span>
                    <span class="font-semibold">{{ $plan->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Amount</span>
                    <span class="font-semibold">₹{{ number_format($amount, 2) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method</span>
                    <span class="font-semibold uppercase">{{ $paymentMethod }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <!-- Razorpay Payment Button (Placeholder) -->
            <div id="razorpay-container" class="p-4 border border-indigo-200 rounded-lg bg-indigo-50">
                <p class="text-sm text-gray-600 mb-4">Redirecting to Razorpay payment gateway...</p>
                
                <!-- For Testing: Direct links to success/failed -->
                <div class="space-y-2">
                    <a href="{{ route('instructor.subscription.payment-success', ['plan' => $plan->id]) }}" 
                       class="block w-full text-center bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                        ✓ Test: Payment Success
                    </a>
                    <a href="{{ route('instructor.subscription.payment-failed', ['plan' => $plan->id]) }}" 
                       class="block w-full text-center bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition">
                        ✗ Test: Payment Failed
                    </a>
                </div>
            </div>

            <a href="{{ route('instructor.subscription.payment', ['plan' => $plan->id]) }}" 
               class="block w-full text-center bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                Back to Payment Method Selection
            </a>
        </div>

        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded text-sm text-yellow-700">
            <p class="font-semibold mb-2">⏱️ Integration Note</p>
            <p>The actual Razorpay payment gateway integration should be implemented here. Currently showing test buttons for development.</p>
        </div>
    </div>

    <!-- Razorpay Script (to be enabled when integrating) -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        // TODO: Implement Razorpay integration
        // var options = {
        //     key: "{{ config('services.razorpay.key') }}",
        //     amount: {{ $amount * 100 }},
        //     currency: "INR",
        //     name: "Medniks",
        //     description: "Subscription: {{ $plan->name }}",
        //     image: "{{ asset('logo.png') }}",
        //     handler: function(response) {
        //         window.location.href = "{{ route('instructor.subscription.payment-success', ['plan' => $plan->id]) }}?payment_id=" + response.razorpay_payment_id;
        //     },
        //     prefill: {
        //         name: "{{ $user->name }}",
        //         email: "{{ $user->email }}",
        //         contact: "{{ $user->phone }}"
        //     }
        // };
        // var rzp1 = new Razorpay(options);
        // document.getElementById('razorpay-button').onclick = function(e) {
        //     rzp1.open();
        //     e.preventDefault();
        // }
    </script>
</x-layouts.instructor>
