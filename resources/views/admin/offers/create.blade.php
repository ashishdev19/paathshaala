<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Offer') }}
            </h2>
            <a href="{{ route('admin.offers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i>Back to Offers
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Create Promotional Offer</h3>
                        <p class="text-gray-600">Design attractive offers, discounts, and coupons for your students</p>
                    </div>

                    <form action="{{ route('admin.offers.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Basic Information Section -->
                        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 p-6 rounded-xl border border-indigo-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-indigo-600 mr-2"></i>
                                Basic Information
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Title -->
                                <div class="md:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Offer Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('title') border-red-500 @enderror"
                                           placeholder="e.g., Student Discount Special, Black Friday Sale">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="3" 
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('description') border-red-500 @enderror"
                                              placeholder="Describe the offer details and benefits for students">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Offer Type -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Discount Type</label>
                                    <select name="type" id="type" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('type') border-red-500 @enderror">
                                        <option value="">Select discount type</option>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage Discount (%)</option>
                                        <option value="fixed_amount" {{ old('type') == 'fixed_amount' ? 'selected' : '' }}>Fixed Amount Discount ($)</option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                                    </div>
                                    @error('is_active')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Discount Configuration Section -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-percentage text-green-600 mr-2"></i>
                                Discount Configuration
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Discount Value -->
                                <div>
                                    <label for="value" class="block text-sm font-medium text-gray-700 mb-2">Discount Value</label>
                                    <input type="number" name="value" id="value" value="{{ old('value') }}" 
                                           min="0" step="0.01"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('value') border-red-500 @enderror"
                                           placeholder="e.g., 25 (for 25% or $25)">
                                    @error('value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Enter percentage value (e.g., 25 for 25%) or dollar amount (e.g., 50 for $50)</p>
                                </div>

                                <!-- Minimum Order Amount -->
                                <div>
                                    <label for="minimum_amount" class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Amount ($)</label>
                                    <input type="number" name="minimum_amount" id="minimum_amount" value="{{ old('minimum_amount') }}" 
                                           min="0" step="0.01"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('minimum_amount') border-red-500 @enderror"
                                           placeholder="e.g., 100.00">
                                    @error('minimum_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">Leave empty if no minimum purchase required</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Note:</strong> Select discount type above, then enter the corresponding value. For percentage: enter 25 for 25% off. For fixed amount: enter 50 for $50 off.
                                </p>
                            </div>
                        </div>

                        <!-- Coupon & Validity Section -->
                        <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-ticket-alt text-purple-600 mr-2"></i>
                                Coupon Code & Validity
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Coupon Code -->
                                <div>
                                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Coupon Code</label>
                                    <div class="flex">
                                        <input type="text" name="code" id="code" value="{{ old('code') }}" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('code') border-red-500 @enderror"
                                               placeholder="e.g., STUDENT20">
                                        <button type="button" onclick="generateCouponCode()" 
                                                class="px-4 py-3 bg-purple-600 text-white border border-purple-600 rounded-r-lg hover:bg-purple-700 transition duration-150 ease-in-out">
                                            <i class="fas fa-magic"></i>
                                        </button>
                                    </div>
                                    @error('code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Usage Limit -->
                                <div>
                                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">Usage Limit</label>
                                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" 
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('usage_limit') border-red-500 @enderror"
                                           placeholder="e.g., 100 (leave empty for unlimited)">
                                    @error('usage_limit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <label for="valid_from" class="block text-sm font-medium text-gray-700 mb-2">Valid From</label>
                                    <input type="datetime-local" name="valid_from" id="valid_from" value="{{ old('valid_from') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('valid_from') border-red-500 @enderror">
                                    @error('valid_from')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="valid_until" class="block text-sm font-medium text-gray-700 mb-2">Valid Until</label>
                                    <input type="datetime-local" name="valid_until" id="valid_until" value="{{ old('valid_until') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('valid_until') border-red-500 @enderror">
                                    @error('valid_until')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Terms & Conditions Section -->
                        <div class="bg-gradient-to-r from-orange-50 to-red-50 p-6 rounded-xl border border-orange-200">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-file-contract text-orange-600 mr-2"></i>
                                Terms & Conditions
                            </h4>
                            
                            <div>
                                <label for="terms_conditions" class="block text-sm font-medium text-gray-700 mb-2">Terms & Conditions</label>
                                <textarea name="terms_conditions" id="terms_conditions" rows="4" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-150 ease-in-out @error('terms_conditions') border-red-500 @enderror"
                                          placeholder="Enter the terms and conditions for this offer...">{{ old('terms_conditions') }}</textarea>
                                @error('terms_conditions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.offers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-8 rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-save mr-2"></i>Create Offer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Coupon Code Generation -->
    <script>
        function generateCouponCode() {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 8; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('code').value = result;
        }

        // Set default start date to now
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            const startDateInput = document.getElementById('valid_from');
            if (!startDateInput.value) {
                startDateInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
            
            // Set default end date to 30 days from now
            const endDate = new Date(now.getTime() + (30 * 24 * 60 * 60 * 1000));
            const endYear = endDate.getFullYear();
            const endMonth = String(endDate.getMonth() + 1).padStart(2, '0');
            const endDay = String(endDate.getDate()).padStart(2, '0');
            const endHours = String(endDate.getHours()).padStart(2, '0');
            const endMinutes = String(endDate.getMinutes()).padStart(2, '0');
            
            const endDateInput = document.getElementById('valid_until');
            if (!endDateInput.value) {
                endDateInput.value = `${endYear}-${endMonth}-${endDay}T${endHours}:${endMinutes}`;
            }
        });
    </script>
</x-admin-layout>