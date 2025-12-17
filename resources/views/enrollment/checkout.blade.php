<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Enrollment Checkout
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Course Details & Offers -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Course Details Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Course Details</h3>
                        <div class="flex gap-4">
                            @if($course->thumbnail)
                                <img src="/storage/{{ $course->thumbnail }}" 
                                     alt="{{ $course->title }}" 
                                     class="w-32 h-24 object-cover rounded-lg"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif
                            @if(!$course->thumbnail || true)
                                <div class="w-32 h-24 bg-blue-100 rounded-lg flex items-center justify-center {{ $course->thumbnail ? 'hidden' : '' }}">
                                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold text-lg text-gray-900">{{ $course->title }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $course->category->name ?? 'General' }}</p>
                                <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ $course->teacher->name ?? 'N/A' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        4.5 (120 reviews)
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Offers -->
                @if($allOffers->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Available Offers</h3>
                        <div class="space-y-3">
                            @foreach($allOffers as $offer)
                            <div class="border-2 {{ $autoAppliedOffer && $autoAppliedOffer->id == $offer->id ? 'border-green-500 bg-green-50' : 'border-gray-200' }} rounded-lg p-4 offer-card cursor-pointer hover:border-blue-500 transition"
                                 data-offer-id="{{ $offer->id }}"
                                 data-discount-type="{{ $offer->discount_type }}"
                                 data-discount-value="{{ $offer->discount_value }}"
                                 data-course-price="{{ $course->price }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-orange-500 text-white text-xs font-bold px-3 py-1 rounded">
                                                {{ $offer->code }}
                                            </span>
                                            @if($autoAppliedOffer && $autoAppliedOffer->id == $offer->id)
                                            <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
                                                AUTO APPLIED
                                            </span>
                                            @endif
                                        </div>
                                        <h4 class="font-semibold text-gray-900">{{ $offer->name }}</h4>
                                        <p class="text-sm text-gray-600 mt-1">{{ $offer->description }}</p>
                                        <p class="text-sm font-semibold text-green-600 mt-2">
                                            Save {{ $offer->discount_type === 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }}
                                        </p>
                                    </div>
                                    <input type="radio" 
                                           name="offer_id" 
                                           value="{{ $offer->id }}"
                                           {{ $autoAppliedOffer && $autoAppliedOffer->id == $offer->id ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 text-blue-600">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- New Student Notice -->
                @if($isNewStudent)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900">Welcome New Student!</h4>
                            <p class="text-sm text-blue-700 mt-1">This is your first course enrollment. Enjoy special new student discounts!</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Price Summary & Payment -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-4">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Order Summary</h3>
                        
                        <!-- Error Messages -->
                        @if($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-red-800">
                                    <strong>Error:</strong>
                                    <ul class="mt-1 list-disc list-inside">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-red-800">
                                    <strong>Error:</strong> {{ session('error') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Price Breakdown -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-700">
                                <span>Course Price</span>
                                <span class="font-semibold">₹{{ number_format($course->price, 2) }}</span>
                            </div>
                            
                            <div id="discount-section" class="flex justify-between text-green-600 {{ !$autoAppliedOffer ? 'hidden' : '' }}">
                                <span>Discount</span>
                                <span class="font-semibold">-₹<span id="discount-amount">{{ $autoAppliedOffer ? number_format($course->price - $discountedPrice, 2) : '0.00' }}</span></span>
                            </div>
                            
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-bold text-gray-900">
                                    <span>Total Amount</span>
                                    <span id="final-price">₹<span id="final-amount">{{ number_format($discountedPrice ?? $course->price, 2) }}</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <form action="{{ route('enrollment.store', $course->id) }}" method="POST" id="enrollment-form">
                            @csrf
                            <input type="hidden" name="offer_id" id="selected-offer-id" value="{{ $autoAppliedOffer?->id }}">
                            <input type="hidden" name="amount" id="payment-amount" value="{{ $discountedPrice ?? $course->price }}">

                            <!-- Payment Method -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Payment Method (Development Mode)</label>
                                <div class="space-y-2">
                                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-option">
                                        <input type="radio" name="payment_method" value="credit_card" checked class="w-4 h-4 text-blue-600">
                                        <span class="ml-3">
                                            <span class="font-medium text-gray-900 block">Credit Card</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-option">
                                        <input type="radio" name="payment_method" value="debit_card" class="w-4 h-4 text-blue-600">
                                        <span class="ml-3">
                                            <span class="font-medium text-gray-900 block">Debit Card</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-option">
                                        <input type="radio" name="payment_method" value="upi" class="w-4 h-4 text-blue-600">
                                        <span class="ml-3">
                                            <span class="font-medium text-gray-900 block">UPI</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition payment-method-option">
                                        <input type="radio" name="payment_method" value="net_banking" class="w-4 h-4 text-blue-600">
                                        <span class="ml-3">
                                            <span class="font-medium text-gray-900 block">Net Banking</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Development Mode Notice -->
                            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <div class="flex items-start gap-2">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <div class="text-sm text-yellow-800">
                                        <strong>Development Mode:</strong> Payment fields are not required. Click "Complete Enrollment" to proceed.
                                    </div>
                                </div>
                            </div>

                            <!-- Card Details (shown when credit/debit card selected) - Optional in dev mode -->
                            <div id="card-details" class="mb-4 space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Number <span class="text-gray-400">(Optional)</span></label>
                                    <input type="text" name="card_number" maxlength="16" placeholder="1234 5678 9012 3456" value="4111111111111111"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Holder Name <span class="text-gray-400">(Optional)</span></label>
                                    <input type="text" name="card_holder_name" placeholder="John Doe" value="Test User"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiry <span class="text-gray-400">(Optional)</span></label>
                                        <input type="text" name="card_expiry" maxlength="5" placeholder="12/25" value="12/25"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVV <span class="text-gray-400">(Optional)</span></label>
                                        <input type="text" name="card_cvv" maxlength="3" placeholder="123" value="123"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                                    </div>
                                </div>
                            </div>

                            <!-- UPI Details (shown when UPI selected) - Optional in dev mode -->
                            <div id="upi-details" class="mb-4 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">UPI ID <span class="text-gray-400">(Optional)</span></label>
                                <input type="text" name="upi_id" placeholder="yourname@upi" value="test@upi"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                            </div>

                            <!-- Net Banking Details (shown when Net Banking selected) - Optional in dev mode -->
                            <div id="netbanking-details" class="mb-4 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Select Bank <span class="text-gray-400">(Optional)</span></label>
                                <select name="bank_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50">
                                    <option value="Test Bank" selected>Test Bank</option>
                                    <option value="SBI">State Bank of India</option>
                                    <option value="HDFC">HDFC Bank</option>
                                    <option value="ICICI">ICICI Bank</option>
                                    <option value="Axis">Axis Bank</option>
                                    <option value="PNB">Punjab National Bank</option>
                                    <option value="BOB">Bank of Baroda</option>
                                </select>
                            </div>

                            <!-- Proceed Button -->
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Complete Enrollment (Dev Mode)
                            </button>
                        </form>

                        <!-- Development Note -->
                        <div class="mt-4 flex items-start gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Development mode: No actual payment will be processed. Enrollment will be completed automatically.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Handle payment method changes
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Hide all payment details
                document.getElementById('card-details').classList.add('hidden');
                document.getElementById('upi-details').classList.add('hidden');
                document.getElementById('netbanking-details').classList.add('hidden');
                
                // Show relevant payment details
                if (this.value === 'credit_card' || this.value === 'debit_card') {
                    document.getElementById('card-details').classList.remove('hidden');
                } else if (this.value === 'upi') {
                    document.getElementById('upi-details').classList.remove('hidden');
                } else if (this.value === 'net_banking') {
                    document.getElementById('netbanking-details').classList.remove('hidden');
                }
                
                // Update border highlight
                document.querySelectorAll('.payment-method-option').forEach(option => {
                    option.classList.remove('border-blue-500', 'bg-blue-50');
                    option.classList.add('border-gray-200');
                });
                this.closest('.payment-method-option').classList.remove('border-gray-200');
                this.closest('.payment-method-option').classList.add('border-blue-500', 'bg-blue-50');
            });
        });

        // Handle offer selection
        document.querySelectorAll('.offer-card').forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                updatePrice();
                
                // Update visual state
                document.querySelectorAll('.offer-card').forEach(c => {
                    c.classList.remove('border-green-500', 'bg-green-50');
                    c.classList.add('border-gray-200');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-green-500', 'bg-green-50');
            });
        });

        // Update price when offer changes
        function updatePrice() {
            const selectedOffer = document.querySelector('input[name="offer_id"]:checked');
            const coursePrice = {{ $course->price }};
            
            if (selectedOffer) {
                const offerId = selectedOffer.value;
                const card = selectedOffer.closest('.offer-card');
                const discountType = card.dataset.discountType;
                const discountValue = parseFloat(card.dataset.discountValue);
                
                let discount = 0;
                if (discountType === 'percentage') {
                    discount = (coursePrice * discountValue) / 100;
                } else {
                    discount = discountValue;
                }
                
                const finalPrice = coursePrice - discount;
                
                // Update UI
                document.getElementById('discount-section').classList.remove('hidden');
                document.getElementById('discount-amount').textContent = discount.toFixed(2);
                document.getElementById('final-amount').textContent = finalPrice.toFixed(2);
                document.getElementById('selected-offer-id').value = offerId;
                document.getElementById('payment-amount').value = finalPrice.toFixed(2);
            } else {
                // No offer selected
                document.getElementById('discount-section').classList.add('hidden');
                document.getElementById('final-amount').textContent = coursePrice.toFixed(2);
                document.getElementById('selected-offer-id').value = '';
                document.getElementById('payment-amount').value = coursePrice.toFixed(2);
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            const checkedOffer = document.querySelector('input[name="offer_id"]:checked');
            if (checkedOffer) {
                updatePrice();
            }
            
            // Highlight default payment method
            const defaultPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (defaultPaymentMethod) {
                defaultPaymentMethod.closest('.payment-method-option').classList.add('border-blue-500', 'bg-blue-50');
                defaultPaymentMethod.closest('.payment-method-option').classList.remove('border-gray-200');
            }
        });
    </script>
    @endpush
</x-layouts.student>
