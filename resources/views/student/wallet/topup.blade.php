<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Add Money to Wallet
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-8">
            <!-- Current Balance -->
            <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-600 mb-1">Current Wallet Balance</p>
                <p class="text-3xl font-bold text-blue-900">₹{{ number_format($wallet->balance, 2) }}</p>
            </div>

            <!-- Top-up Form -->
            <form action="{{ route('student.wallet.topup.initiate') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Amount Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Amount to Add</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 text-gray-600 text-lg">₹</span>
                        <input 
                            type="number" 
                            name="amount" 
                            step="0.01" 
                            min="100" 
                            max="50000" 
                            value="{{ old('amount') }}"
                            placeholder="Enter amount (Min: ₹100, Max: ₹50,000)"
                            class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required
                        >
                    </div>
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-2">Minimum: ₹100 | Maximum: ₹50,000</p>
                </div>

                <!-- Payment Gateway Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                    <div class="space-y-3">
                        <!-- Razorpay -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input 
                                type="radio" 
                                name="gateway" 
                                value="razorpay" 
                                class="w-4 h-4 text-blue-600"
                                @if(old('gateway') === 'razorpay' || !old('gateway')) checked @endif
                            >
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">Razorpay</p>
                                <p class="text-sm text-gray-500">Fast and secure payment</p>
                            </div>
                            <img src="https://www.razorpay.com/assets/razorpay-glyph.svg" alt="Razorpay" class="ml-auto h-6">
                        </label>

                        <!-- Stripe -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input 
                                type="radio" 
                                name="gateway" 
                                value="stripe" 
                                class="w-4 h-4 text-blue-600"
                                @if(old('gateway') === 'stripe') checked @endif
                            >
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">Stripe</p>
                                <p class="text-sm text-gray-500">Credit/Debit Card</p>
                            </div>
                            <img src="https://cdn.worldvectorlogo.com/logos/stripe-2.svg" alt="Stripe" class="ml-auto h-6">
                        </label>

                        <!-- PayTM -->
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                            <input 
                                type="radio" 
                                name="gateway" 
                                value="paytm" 
                                class="w-4 h-4 text-blue-600"
                                @if(old('gateway') === 'paytm') checked @endif
                            >
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900">PayTM</p>
                                <p class="text-sm text-gray-500">PayTM Wallet & UPI</p>
                            </div>
                            <img src="https://assets.paytm.com/images/favicon/favicon.png" alt="PayTM" class="ml-auto h-6">
                        </label>
                    </div>
                    @error('gateway')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quick Amount Buttons -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Quick Add</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <button type="button" class="quick-amount py-2 px-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium" data-amount="500">₹500</button>
                        <button type="button" class="quick-amount py-2 px-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium" data-amount="1000">₹1,000</button>
                        <button type="button" class="quick-amount py-2 px-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium" data-amount="5000">₹5,000</button>
                        <button type="button" class="quick-amount py-2 px-3 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm font-medium" data-amount="10000">₹10,000</button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3 pt-6 border-t border-gray-200">
                    <button 
                        type="submit" 
                        class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold"
                    >
                        <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Proceed to Payment
                    </button>
                    <a 
                        href="{{ route('student.wallet.index') }}" 
                        class="flex-1 bg-gray-200 text-gray-900 py-3 rounded-lg hover:bg-gray-300 font-semibold text-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Security Info -->
            <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="font-semibold text-green-900">Your payment is secure</h3>
                        <p class="text-sm text-green-700 mt-1">We use industry-standard SSL encryption to protect your payment information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for Quick Amount Buttons -->
    <script>
        document.querySelectorAll('.quick-amount').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                document.querySelector('input[name="amount"]').value = btn.getAttribute('data-amount');
                document.querySelector('input[name="amount"]').focus();
            });
        });
    </script>
</x-layouts.student>
