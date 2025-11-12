<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - {{ $course->title }} - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Paathshaala</h1>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        Welcome, {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center">
                    <div class="flex items-center">
                        <div class="flex items-center text-indigo-600">
                            <div class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full text-sm font-medium">
                                1
                            </div>
                            <span class="ml-2 text-sm font-medium">Course Selection</span>
                        </div>
                        <div class="flex-1 h-0.5 bg-indigo-600 mx-4 w-16"></div>
                        <div class="flex items-center text-indigo-600">
                            <div class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full text-sm font-medium">
                                2
                            </div>
                            <span class="ml-2 text-sm font-medium">Payment</span>
                        </div>
                        <div class="flex-1 h-0.5 bg-gray-300 mx-4 w-16"></div>
                        <div class="flex items-center text-gray-400">
                            <div class="flex items-center justify-center w-8 h-8 bg-gray-300 text-gray-600 rounded-full text-sm font-medium">
                                3
                            </div>
                            <span class="ml-2 text-sm font-medium">Confirmation</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Payment Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Information</h2>
                        
                        @if ($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg mb-6">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('enrollment.store', $course->id) }}" method="POST" id="paymentForm">
                            @csrf
                            
                            <!-- Payment Method Selection -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <label class="payment-method-option cursor-pointer">
                                        <input type="radio" name="payment_method" value="credit_card" class="sr-only payment-method-radio" required>
                                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-indigo-500 transition duration-200">
                                            <div class="text-2xl mb-2">💳</div>
                                            <div class="text-sm font-medium">Credit Card</div>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method-option cursor-pointer">
                                        <input type="radio" name="payment_method" value="debit_card" class="sr-only payment-method-radio">
                                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-indigo-500 transition duration-200">
                                            <div class="text-2xl mb-2">💳</div>
                                            <div class="text-sm font-medium">Debit Card</div>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method-option cursor-pointer">
                                        <input type="radio" name="payment_method" value="upi" class="sr-only payment-method-radio">
                                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-indigo-500 transition duration-200">
                                            <div class="text-2xl mb-2">📱</div>
                                            <div class="text-sm font-medium">UPI</div>
                                        </div>
                                    </label>
                                    
                                    <label class="payment-method-option cursor-pointer">
                                        <input type="radio" name="payment_method" value="net_banking" class="sr-only payment-method-radio">
                                        <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-indigo-500 transition duration-200">
                                            <div class="text-2xl mb-2">🏦</div>
                                            <div class="text-sm font-medium">Net Banking</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Card Details -->
                            <div id="cardDetails" class="payment-details hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="md:col-span-2">
                                        <label for="card_holder_name" class="block text-sm font-medium text-gray-700 mb-2">Card Holder Name</label>
                                        <input type="text" id="card_holder_name" name="card_holder_name" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                               placeholder="John Doe">
                                    </div>
                                    
                                    <div class="md:col-span-2">
                                        <label for="card_number" class="block text-sm font-medium text-gray-700 mb-2">Card Number</label>
                                        <input type="text" id="card_number" name="card_number" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                               placeholder="1234567812345678" maxlength="16">
                                    </div>
                                    
                                    <div>
                                        <label for="card_expiry" class="block text-sm font-medium text-gray-700 mb-2">Expiry Date</label>
                                        <input type="text" id="card_expiry" name="card_expiry" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                               placeholder="MM/YY" maxlength="5">
                                    </div>
                                    
                                    <div>
                                        <label for="card_cvv" class="block text-sm font-medium text-gray-700 mb-2">CVV</label>
                                        <input type="text" id="card_cvv" name="card_cvv" 
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                               placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>

                            <!-- UPI Details -->
                            <div id="upiDetails" class="payment-details hidden">
                                <div class="mb-6">
                                    <label for="upi_id" class="block text-sm font-medium text-gray-700 mb-2">UPI ID</label>
                                    <input type="email" id="upi_id" name="upi_id" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                           placeholder="your-upi@paytm">
                                </div>
                            </div>

                            <!-- Net Banking Details -->
                            <div id="netBankingDetails" class="payment-details hidden">
                                <div class="mb-6">
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-2">Select Bank</label>
                                    <select id="bank_name" name="bank_name" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Choose your bank</option>
                                        <option value="State Bank of India">State Bank of India</option>
                                        <option value="HDFC Bank">HDFC Bank</option>
                                        <option value="ICICI Bank">ICICI Bank</option>
                                        <option value="Axis Bank">Axis Bank</option>
                                        <option value="Punjab National Bank">Punjab National Bank</option>
                                        <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                                        <option value="IndusInd Bank">IndusInd Bank</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Security Notice -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-medium mb-1">Secure Payment</p>
                                        <p>Your payment information is encrypted and secure. We do not store your card details.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-indigo-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 disabled:opacity-50"
                                    id="submitBtn">
                                Complete Payment - ₹{{ number_format($course->price) }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                        
                        <div class="space-y-4">
                            <div class="flex space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-xs font-medium">{{ substr($course->category, 0, 3) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $course->title }}</h4>
                                    <p class="text-sm text-gray-600">by {{ $course->teacher->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $course->duration }} hours</p>
                                </div>
                            </div>
                            
                            <div class="border-t pt-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Course Price</span>
                                    <span class="text-gray-900">₹{{ number_format($course->price) }}</span>
                                </div>
                                <div class="flex justify-between text-sm mt-2">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-900">₹0</span>
                                </div>
                                <div class="flex justify-between text-lg font-semibold mt-4 pt-4 border-t">
                                    <span>Total</span>
                                    <span class="text-indigo-600">₹{{ number_format($course->price) }}</span>
                                </div>
                            </div>
                            
                            <div class="border-t pt-4">
                                <h4 class="font-medium text-gray-900 mb-2">What you'll get:</h4>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Lifetime access
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $course->duration }} hours of content
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Certificate of completion
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Mobile access
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method-radio').forEach(radio => {
            radio.addEventListener('change', function() {
                // Reset all options
                document.querySelectorAll('.payment-method-option > div').forEach(div => {
                    div.classList.remove('border-indigo-500', 'bg-indigo-50');
                    div.classList.add('border-gray-200');
                });
                
                // Hide all payment details
                document.querySelectorAll('.payment-details').forEach(details => {
                    details.classList.add('hidden');
                });
                
                // Highlight selected option
                const selectedDiv = this.parentElement.querySelector('div');
                selectedDiv.classList.remove('border-gray-200');
                selectedDiv.classList.add('border-indigo-500', 'bg-indigo-50');
                
                // Show relevant payment details
                const method = this.value;
                if (method === 'credit_card' || method === 'debit_card') {
                    document.getElementById('cardDetails').classList.remove('hidden');
                } else if (method === 'upi') {
                    document.getElementById('upiDetails').classList.remove('hidden');
                } else if (method === 'net_banking') {
                    document.getElementById('netBankingDetails').classList.remove('hidden');
                }
            });
        });

        // Card number formatting
        document.getElementById('card_number')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Expiry date formatting
        document.getElementById('card_expiry')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // CVV formatting
        document.getElementById('card_cvv')?.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value;
        });

        // Form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing Payment...';
        });
    </script>
</body>
</html>