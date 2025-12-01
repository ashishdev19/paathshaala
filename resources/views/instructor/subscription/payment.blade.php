<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">Subscription Payment</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg border border-indigo-100 p-6">
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Summary -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-200">
                <h3 class="text-lg font-semibold mb-4 text-indigo-900">Order Summary</h3>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Plan Name</span>
                        <span class="font-semibold">{{ $plan->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-semibold">1 Year</span>
                    </div>
                    @if($currentSubscription)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Current Plan</span>
                            <span class="font-semibold">{{ $currentSubscription->plan->name }}</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between">
                            <span class="text-gray-600">Pro-rated Upgrade Cost</span>
                            <span class="font-semibold text-indigo-600">₹{{ number_format($amount, 2) }}</span>
                        </div>
                    @else
                        <div class="border-t pt-3 flex justify-between">
                            <span class="text-gray-600">Plan Price</span>
                            <span class="font-semibold text-indigo-600">₹{{ number_format($amount, 2) }}</span>
                        </div>
                    @endif
                </div>

                <div class="border-t-2 pt-4 flex justify-between items-center">
                    <span class="text-lg font-semibold">Total Amount</span>
                    <span class="text-2xl font-bold text-indigo-600">₹{{ number_format($amount, 2) }}</span>
                </div>
            </div>

            <!-- Payment Form -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Select Payment Method</h3>
                
                <form action="{{ route('instructor.subscription.payment-process', ['plan' => $plan->id]) }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="space-y-3">
                        <!-- Razorpay -->
                        <label class="flex items-center p-4 border border-indigo-100 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition duration-200">
                            <input type="radio" name="payment_method" value="razorpay" class="w-4 h-4 text-indigo-600" checked>
                            <span class="ml-3">
                                <span class="block font-semibold text-gray-800">Razorpay</span>
                                <span class="text-sm text-gray-600">Credit/Debit Card, UPI, Wallet</span>
                            </span>
                        </label>

                        <!-- Card -->
                        <label class="flex items-center p-4 border border-indigo-100 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition duration-200">
                            <input type="radio" name="payment_method" value="card" class="w-4 h-4 text-indigo-600">
                            <span class="ml-3">
                                <span class="block font-semibold text-gray-800">Credit/Debit Card</span>
                                <span class="text-sm text-gray-600">Visa, Mastercard, Amex</span>
                            </span>
                        </label>

                        <!-- UPI -->
                        <label class="flex items-center p-4 border border-indigo-100 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition duration-200">
                            <input type="radio" name="payment_method" value="upi" class="w-4 h-4 text-indigo-600">
                            <span class="ml-3">
                                <span class="block font-semibold text-gray-800">UPI</span>
                                <span class="text-sm text-gray-600">Google Pay, PhonePe, Paytm</span>
                            </span>
                        </label>

                        <!-- Net Banking -->
                        <label class="flex items-center p-4 border border-indigo-100 rounded-lg cursor-pointer hover:bg-indigo-50 hover:border-indigo-300 transition duration-200">
                            <input type="radio" name="payment_method" value="netbanking" class="w-4 h-4 text-indigo-600">
                            <span class="ml-3">
                                <span class="block font-semibold text-gray-800">Net Banking</span>
                                <span class="text-sm text-gray-600">All major banks</span>
                            </span>
                        </label>
                    </div>

                    <div class="mt-6 space-y-2">
                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition duration-200 shadow-md hover:shadow-lg">
                            Proceed to Payment
                        </button>
                        <a href="{{ route('instructor.subscription.upgrade') }}" class="block w-full text-center bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Back to Plans
                        </a>
                    </div>
                </form>

                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded text-sm text-green-700">
                    <p class="font-semibold mb-2">✓ Secure Payment</p>
                    <p>Your payment information is encrypted and safe. You will be able to access all course creation features immediately after successful payment.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.instructor>
