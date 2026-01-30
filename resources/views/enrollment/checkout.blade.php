<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Enrollment Checkout
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Referral Discount Alert -->
        @if(isset($pendingReferral) && $pendingReferral)
        <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-2 border-purple-300 rounded-xl p-6 mb-8 shadow-lg">
            <div class="flex items-center gap-4">
                <div class="bg-purple-600 rounded-full p-3">
                    <i class="fas fa-gift text-white text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-purple-900">Referral Discount Applied! 🎉</h3>
                    <p class="text-purple-700 mt-1">
                        You're getting <strong class="text-2xl text-purple-900">₹{{ number_format($referralDiscount, 2) }}</strong> off this course because you used a referral code!
                    </p>
                    <p class="text-sm text-purple-600 mt-2">This discount has been automatically applied to your order.</p>
                </div>
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Course Details & Offers -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Course Details Card -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8">Course Details</h3>
                        <div class="flex gap-8">
                            <img src="{{ $course->thumbnail_url }}" 
                                 alt="{{ $course->title }}" 
                                 class="w-48 h-36 object-cover rounded-xl shadow-md">
                            <div class="flex-1">
                                <h4 class="font-bold text-xl text-gray-900">{{ $course->title }}</h4>
                                <p class="text-base text-gray-600 mt-2">{{ $course->category->name ?? 'General' }}</p>
                                <div class="flex items-center gap-6 mt-4 text-sm text-gray-600">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span class="font-medium">{{ $course->teacher->name ?? 'N/A' }}</span>
                                    </span>
                                    <span class="flex items-center gap-2">
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="font-medium">4.5 (120 reviews)</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Offers -->
                @if($allOffers->count() > 0)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8">Available Offers</h3>
                        <div class="space-y-5">
                            @foreach($allOffers as $offer)
                            <div class="relative border-2 {{ $autoAppliedOffer && $autoAppliedOffer->id == $offer->id ? 'border-teal-500 bg-teal-50' : 'border-gray-200' }} rounded-xl p-8 offer-card cursor-pointer hover:border-teal-400 hover:shadow-md transition-all duration-300"
                                 data-offer-id="{{ $offer->id }}"
                                 data-discount-type="{{ $offer->discount_type }}"
                                 data-discount-value="{{ $offer->discount_value }}"
                                 data-course-price="{{ $course->price }}">
                                @if($autoAppliedOffer && $autoAppliedOffer->id == $offer->id)
                                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                                    <span class="bg-teal-500 text-white text-xs font-bold px-4 py-1 rounded-full shadow-md">
                                        AUTO APPLIED
                                    </span>
                                </div>
                                @endif
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-bold px-4 py-1.5 rounded-lg shadow-sm">
                                                {{ $offer->code }}
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-lg text-gray-900">{{ $offer->name }}</h4>
                                        <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $offer->description }}</p>
                                        <p class="text-base font-bold text-green-600 mt-3">
                                            Save {{ $offer->discount_type === 'percentage' ? $offer->discount_value . '%' : '₹' . number_format($offer->discount_value, 2) }}
                                        </p>
                                    </div>
                                    <input type="radio" 
                                           name="offer_id" 
                                           value="{{ $offer->id }}"
                                           {{ $autoAppliedOffer && $autoAppliedOffer->id == $offer->id ? 'checked' : '' }}
                                           class="mt-1 w-5 h-5 text-teal-600">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- New Student Notice -->
                @if($isNewStudent)
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-8 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="bg-blue-600 rounded-full p-3">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-xl text-blue-900">Welcome New Student!</h4>
                            <p class="text-base text-blue-700 mt-3 leading-relaxed">This is your first course enrollment. Enjoy special new student discounts!</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column - Price Summary & Payment -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-4 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8">Order Summary</h3>
                        
                        <!-- Error Messages -->
                        @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-2 border-red-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-red-800">
                                    <strong class="font-bold">Error:</strong>
                                    <ul class="mt-2 list-disc list-inside space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-2 border-red-200 rounded-xl">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="text-sm text-red-800">
                                    <strong class="font-bold">Error:</strong> {{ session('error') }}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Price Breakdown -->
                        <div class="space-y-5 mb-10">
                            <div class="flex justify-between text-gray-700 text-lg">
                                <span class="font-medium">Course Price</span>
                                <span class="font-semibold">₹{{ number_format($course->price, 2) }}</span>
                            </div>
                            
                            @if(isset($pendingReferral) && $pendingReferral)
                            <div class="flex justify-between text-purple-600 text-lg">
                                <span class="font-medium flex items-center gap-2">
                                    <i class="fas fa-gift"></i> Referral Discount
                                </span>
                                <span class="font-bold">-₹{{ number_format($referralDiscount, 2) }}</span>
                            </div>
                            @endif
                            
                            <div id="discount-section" class="flex justify-between text-green-600 text-lg {{ !$autoAppliedOffer ? 'hidden' : '' }}">
                                <span class="font-medium">Offer Discount</span>
                                <span class="font-bold">-₹<span id="discount-amount">{{ $autoAppliedOffer ? number_format($course->price - $discountedPrice - ($referralDiscount ?? 0), 2) : '0.00' }}</span></span>
                            </div>
                            
                            <div class="border-t-2 border-gray-200 pt-6">
                                <div class="flex justify-between text-3xl font-bold text-gray-900">
                                    <span>Total Amount</span>
                                    <span id="final-price" class="text-teal-600">₹<span id="final-amount">{{ number_format($discountedPrice ?? $course->price, 2) }}</span></span>
                                </div>
                                <p class="text-base text-gray-500 mt-3 text-right">per enrollment</p>
                            </div>
                        </div>

                        <!-- Payment Form -->
                        <form action="{{ route('enrollment.store', $course->id) }}" method="POST" id="enrollment-form">
                            @csrf
                            <input type="hidden" name="offer_id" id="selected-offer-id" value="{{ $autoAppliedOffer?->id }}">
                            <input type="hidden" name="amount" id="payment-amount" value="{{ $discountedPrice ?? $course->price }}">

                            <!-- Payment Method -->
                            <div class="mb-8">
                                <label class="block text-lg font-semibold text-gray-900 mb-5">Payment Method</label>
                                <div class="space-y-4">
                                    <label class="flex items-center p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition-all duration-200 payment-method-option">
                                        <input type="radio" name="payment_method" value="credit_card" checked class="w-5 h-5 text-teal-600">
                                        <span class="ml-5">
                                            <span class="font-semibold text-gray-900 block">Credit Card</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition-all duration-200 payment-method-option">
                                        <input type="radio" name="payment_method" value="debit_card" class="w-5 h-5 text-teal-600">
                                        <span class="ml-4">
                                            <span class="font-semibold text-gray-900 block">Debit Card</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition-all duration-200 payment-method-option">
                                        <input type="radio" name="payment_method" value="upi" class="w-5 h-5 text-teal-600">
                                        <span class="ml-4">
                                            <span class="font-semibold text-gray-900 block">UPI</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                    <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-teal-500 hover:bg-teal-50 transition-all duration-200 payment-method-option">
                                        <input type="radio" name="payment_method" value="net_banking" class="w-5 h-5 text-teal-600">
                                        <span class="ml-4">
                                            <span class="font-semibold text-gray-900 block">Net Banking</span>
                                            <span class="text-xs text-gray-500">Test mode - No actual charge</span>
                                        </span>
                                    </label>
                                </div>
                                @error('payment_method')
                                    <p class="text-red-500 text-sm mt-2 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Development Mode Notice -->
                            <div class="mb-8 p-5 bg-yellow-50 border-2 border-yellow-200 rounded-xl">
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <div class="text-sm text-yellow-800">
                                        <strong class="font-bold">Development Mode:</strong> Payment fields are not required. Click "Complete Enrollment" to proceed.
                                    </div>
                                </div>
                            </div>

                            <!-- Card Details (shown when credit/debit card selected) - Optional in dev mode -->
                            <div id="card-details" class="mb-8 space-y-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Number <span class="text-gray-400">(Optional)</span></label>
                                    <input type="text" name="card_number" maxlength="16" placeholder="1234 5678 9012 3456" value="4111111111111111"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Holder Name <span class="text-gray-400">(Optional)</span></label>
                                    <input type="text" name="card_holder_name" placeholder="John Doe" value="Test User"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Expiry <span class="text-gray-400">(Optional)</span></label>
                                        <input type="text" name="card_expiry" maxlength="5" placeholder="12/25" value="12/25"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">CVV <span class="text-gray-400">(Optional)</span></label>
                                        <input type="text" name="card_cvv" maxlength="3" placeholder="123" value="123"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                                    </div>
                                </div>
                            </div>

                            <!-- UPI Details (shown when UPI selected) - Optional in dev mode -->
                            <div id="upi-details" class="mb-6 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">UPI ID <span class="text-gray-400">(Optional)</span></label>
                                <input type="text" name="upi_id" placeholder="yourname@upi" value="test@upi"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
                            </div>

                            <!-- Net Banking Details (shown when Net Banking selected) - Optional in dev mode -->
                            <div id="netbanking-details" class="mb-6 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Bank <span class="text-gray-400">(Optional)</span></label>
                                <select name="bank_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 bg-gray-50">
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
                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-lg py-5 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Complete Enrollment
                            </button>
                        </form>

                        <!-- Development Note -->
                        <div class="mt-4 flex items-start gap-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="leading-relaxed"><strong>Development mode:</strong> No actual payment will be processed. Enrollment will be completed automatically.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50" style="display: none;">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 transform transition-all">
            <div class="p-10 text-center">
                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-br from-green-100 to-teal-100 mb-6">
                    <svg class="h-14 w-14 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <!-- Success Message -->
                <h3 class="text-3xl font-bold text-gray-900 mb-3">Payment Successful!</h3>
                <p class="text-gray-600 text-base mb-8 leading-relaxed">You have been successfully enrolled in <strong id="modal-course-title" class="text-gray-900"></strong>.</p>
                
                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="#" id="goCourseBtn" class="block w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Go to Course
                    </a>
                    <a href="/student/dashboard" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        Go to Dashboard
                    </a>
                    <button onclick="closeSuccessModal()" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-4 px-6 rounded-xl transition-all duration-300">
                        Continue Browsing
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Success Modal Functions
        function showSuccessModal(courseTitle, courseId) {
            document.getElementById('modal-course-title').textContent = courseTitle;
            document.getElementById('goCourseBtn').href = `/student/courses/${courseId}`;
            const modal = document.getElementById('successModal');
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.add('hidden');
            setTimeout(() => {
                modal.style.display = 'none';
                // Redirect to student dashboard
                window.location.href = '/student/dashboard';
            }, 300);
        }

        // Handle form submission with AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const enrollmentForm = document.getElementById('enrollment-form');
            
            if (enrollmentForm) {
                enrollmentForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const form = this;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalBtnText = submitBtn.innerHTML;
                    
                    // Disable button and show loading
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;
                    
                    // Get form data
                    const formData = new FormData(form);
                    
                    // Send AJAX request
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        // Try to parse JSON even if response is not ok
                        return response.json().then(data => {
                            if (!response.ok) {
                                throw data;
                            }
                            return data;
                        });
                    })
                    .then(data => {
                        if (data.success) {
                            // Show success modal
                            showSuccessModal(data.course_title, data.course_id);
                        } else if (data.already_enrolled) {
                            // User is already enrolled, redirect to dashboard
                            window.location.href = '/student/dashboard';
                        } else {
                            // Show error message
                            alert(data.message || 'Enrollment failed. Please try again.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Check if it's an already enrolled error
                        if (error.already_enrolled) {
                            window.location.href = '/student/dashboard';
                        } else {
                            const errorMsg = error.message || 'An error occurred. Please try again.';
                            alert(errorMsg);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    });
                });
            }
        });

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
                    option.classList.remove('border-teal-500', 'bg-teal-50');
                    option.classList.add('border-gray-200');
                });
                this.closest('.payment-method-option').classList.remove('border-gray-200');
                this.closest('.payment-method-option').classList.add('border-teal-500', 'bg-teal-50');
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
                    c.classList.remove('border-teal-500', 'bg-teal-50');
                    c.classList.add('border-gray-200');
                });
                this.classList.remove('border-gray-200');
                this.classList.add('border-teal-500', 'bg-teal-50');
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
                defaultPaymentMethod.closest('.payment-method-option').classList.add('border-teal-500', 'bg-teal-50');
                defaultPaymentMethod.closest('.payment-method-option').classList.remove('border-gray-200');
            }
        });
    </script>
    @endpush
</x-layouts.student>
