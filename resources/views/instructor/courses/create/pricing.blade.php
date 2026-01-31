<x-layouts.instructor>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Create New Course - Step 4: Set Pricing
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="flex items-center w-full">
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Basics</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Media</div>
                    </div>
                    <div class="step-line flex-1"></div>
                    <div class="step">
                        <div class="step-circle bg-green-600 text-white">✓</div>
                        <div class="step-label">Curriculum</div>
                    </div>
                    <div class="step-line active flex-1"></div>
                    <div class="step active">
                        <div class="step-circle bg-blue-600 text-white">4</div>
                        <div class="step-label">Pricing</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('instructor.courses.create.store-pricing') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8 space-y-6">
            @csrf

            <!-- Course Mode Alert -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4">
                <p class="text-blue-800"><strong>Course Mode:</strong> {{ ucfirst($course->course_mode) }}</p>
            </div>

            <!-- Free/Paid Toggle -->
            <div class="border-b pb-6">
                <label class="flex items-center">
                    <input type="checkbox" id="isFree" name="is_free" value="1" {{ $course->is_free ? 'checked' : '' }}
                           class="rounded border-gray-300">
                    <span class="ml-3 font-semibold text-gray-700">This is a FREE course</span>
                </label>
                <p class="mt-2 text-sm text-gray-600">If checked, this course will be free for all students</p>
            </div>

            <!-- Pricing Section -->
            <div id="pricingSection" class="{{ $course->is_free ? 'opacity-50 pointer-events-none' : '' }}">
                <!-- Original Price -->
                <div class="mb-6">
                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                        Course Price <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center">
                        <span class="text-lg font-semibold text-gray-700 mr-2">₹</span>
                        <input type="number" id="price" name="price" value="{{ old('price', $course->price) }}"
                               placeholder="0.00" min="0" step="0.01"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Set the full price of your course</p>
                </div>

                <!-- Discount Price -->
                <div class="mb-6">
                    <label for="discount_price" class="block text-sm font-semibold text-gray-700 mb-2">
                        Discount Price (Optional)
                    </label>
                    <div class="flex items-center">
                        <span class="text-lg font-semibold text-gray-700 mr-2">₹</span>
                        <input type="number" id="discount_price" name="discount_price" value="{{ old('discount_price', $course->discount_price) }}"
                               placeholder="0.00" min="0" step="0.01"
                               class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    @error('discount_price')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">Leave empty if no discount. Will show discount badge if set.</p>
                </div>

                <!-- Discount Percentage Display -->
                <div id="discountDisplay" class="mb-6 p-4 bg-green-50 rounded-lg hidden">
                    <p class="text-sm"><strong>Discount:</strong> <span id="discountPercent">0</span>% off</p>
                </div>

                <!-- GST Settings -->
                <div class="border-t pt-6 mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-percentage text-blue-500 mr-2"></i>GST Settings
                    </h4>
                    
                    <div class="mb-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" id="gstEnabled" name="gst_enabled" value="1" 
                                   {{ old('gst_enabled', $course->gst_enabled ?? true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-3 font-medium text-gray-700">Enable GST for this course</span>
                        </label>
                        <p class="mt-1 text-xs text-gray-500 ml-6">If enabled, GST will be added to the course price during checkout</p>
                    </div>

                    <div id="gstPercentageSection" class="{{ old('gst_enabled', $course->gst_enabled ?? true) ? '' : 'opacity-50 pointer-events-none' }}">
                        <label for="gst_percentage" class="block text-sm font-semibold text-gray-700 mb-2">
                            GST Percentage (%)
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="number" id="gst_percentage" name="gst_percentage" 
                                   value="{{ old('gst_percentage', $course->gst_percentage ?? 18) }}"
                                   min="0" max="100" step="0.01"
                                   class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <span class="text-gray-600">%</span>
                        </div>
                        @error('gst_percentage')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-gray-500">Default GST rate is 18%. You can adjust based on course type.</p>
                    </div>

                    <!-- GST Preview -->
                    <div id="gstPreview" class="mt-4 p-4 bg-blue-50 rounded-lg">
                        <h5 class="font-semibold text-blue-900 mb-2">Price Preview (with GST)</h5>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Course Price:</span>
                                <span id="previewBasePrice" class="font-medium">₹0.00</span>
                            </div>
                            <div class="flex justify-between text-blue-700">
                                <span>GST (<span id="previewGstPercent">18</span>%):</span>
                                <span id="previewGstAmount" class="font-medium">₹0.00</span>
                            </div>
                            <div class="flex justify-between border-t border-blue-200 pt-2 mt-2">
                                <span class="font-bold text-gray-900">Total:</span>
                                <span id="previewTotalPrice" class="font-bold text-green-600">₹0.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validity Period -->
            <div class="border-t pt-6">
                <label for="validity_days" class="block text-sm font-semibold text-gray-700 mb-2">
                    Course Validity (days)
                </label>
                <input type="number" id="validity_days" name="validity_days" value="{{ old('validity_days', $course->validity_days) }}"
                       placeholder="365" min="1"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="mt-2 text-xs text-gray-500">How long students can access the course after enrollment (leave empty for lifetime)</p>
            </div>

            <!-- Navigation Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('instructor.courses.create.curriculum') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                    ← Back to Curriculum
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold">
                    Complete Course Creation
                </button>
            </div>
        </form>
    </div>

    <script>
        const isFreeCheckbox = document.getElementById('isFree');
        const pricingSection = document.getElementById('pricingSection');
        const priceInput = document.getElementById('price');
        const discountInput = document.getElementById('discount_price');
        const discountDisplay = document.getElementById('discountDisplay');

        isFreeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                pricingSection.classList.add('opacity-50', 'pointer-events-none');
            } else {
                pricingSection.classList.remove('opacity-50', 'pointer-events-none');
            }
        });

        [priceInput, discountInput].forEach(input => {
            input.addEventListener('input', function() {
                const price = parseFloat(priceInput.value) || 0;
                const discount = parseFloat(discountInput.value) || 0;

                if (discount > 0 && price > 0) {
                    const percent = Math.round(((price - discount) / price) * 100);
                    document.getElementById('discountPercent').textContent = percent;
                    discountDisplay.classList.remove('hidden');
                } else {
                    discountDisplay.classList.add('hidden');
                }
            });
        });

        // GST Toggle and Preview
        const gstEnabledCheckbox = document.getElementById('gstEnabled');
        const gstPercentageSection = document.getElementById('gstPercentageSection');
        const gstPercentageInput = document.getElementById('gst_percentage');
        const gstPreview = document.getElementById('gstPreview');

        gstEnabledCheckbox.addEventListener('change', function() {
            if (this.checked) {
                gstPercentageSection.classList.remove('opacity-50', 'pointer-events-none');
                gstPreview.classList.remove('hidden');
            } else {
                gstPercentageSection.classList.add('opacity-50', 'pointer-events-none');
                gstPreview.classList.add('hidden');
            }
            updateGstPreview();
        });

        function updateGstPreview() {
            const price = parseFloat(priceInput.value) || 0;
            const discountPrice = parseFloat(discountInput.value) || 0;
            const basePrice = discountPrice > 0 ? discountPrice : price;
            const gstPercent = parseFloat(gstPercentageInput.value) || 18;
            const gstEnabled = gstEnabledCheckbox.checked;
            
            const gstAmount = gstEnabled ? (basePrice * gstPercent / 100) : 0;
            const totalPrice = basePrice + gstAmount;
            
            document.getElementById('previewBasePrice').textContent = '₹' + basePrice.toFixed(2);
            document.getElementById('previewGstPercent').textContent = gstPercent;
            document.getElementById('previewGstAmount').textContent = '₹' + gstAmount.toFixed(2);
            document.getElementById('previewTotalPrice').textContent = '₹' + totalPrice.toFixed(2);
        }

        // Update GST preview on any price/gst input change
        [priceInput, discountInput, gstPercentageInput].forEach(input => {
            input.addEventListener('input', updateGstPreview);
        });

        // Trigger on load
        [priceInput, discountInput].forEach(input => input.dispatchEvent(new Event('input')));
        updateGstPreview();
    </script>

    <style>
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .step-label {
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }

        .step-line {
            height: 2px;
            background-color: #e5e7eb;
            margin: 0 8px;
            margin-top: 20px;
        }

        .step-line.active {
            background-color: #2563eb;
        }

        .step.active .step-circle {
            background-color: #2563eb;
            color: white;
        }
    </style>
</x-layouts.instructor>
