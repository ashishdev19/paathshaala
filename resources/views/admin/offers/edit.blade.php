<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Offer: ') . $offer->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.offers.show', $offer) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-eye mr-2"></i>View Offer
                </a>
                <a href="{{ route('admin.offers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Offers
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Edit Promotional Offer</h3>
                        <p class="text-gray-600">Update offer details, discounts, and coupon information</p>
                    </div>

                    <form action="{{ route('admin.offers.update', $offer) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

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
                                    <input type="text" name="title" id="title" value="{{ old('title', $offer->title) }}" 
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
                                              placeholder="Describe the offer details and benefits for students">{{ old('description', $offer->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Offer Type -->
                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Offer Type</label>
                                    <select name="type" id="type" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('type') border-red-500 @enderror">
                                        <option value="">Select offer type</option>
                                        <option value="discount" {{ old('type', $offer->type) == 'discount' ? 'selected' : '' }}>Discount Coupon</option>
                                        <option value="bogo" {{ old('type', $offer->type) == 'bogo' ? 'selected' : '' }}>Buy One Get One</option>
                                        <option value="seasonal" {{ old('type', $offer->type) == 'seasonal' ? 'selected' : '' }}>Seasonal Offer</option>
                                        <option value="bundle" {{ old('type', $offer->type) == 'bundle' ? 'selected' : '' }}>Bundle Deal</option>
                                        <option value="loyalty" {{ old('type', $offer->type) == 'loyalty' ? 'selected' : '' }}>Loyalty Reward</option>
                                        <option value="referral" {{ old('type', $offer->type) == 'referral' ? 'selected' : '' }}>Referral Bonus</option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" id="status" 
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('status') border-red-500 @enderror">
                                        <option value="active" {{ old('status', $offer->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $offer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="scheduled" {{ old('status', $offer->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        <option value="expired" {{ old('status', $offer->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                    @error('status')
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
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Discount Percentage -->
                                <div>
                                    <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-2">Discount Percentage (%)</label>
                                    <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $offer->discount_percentage) }}" 
                                           min="0" max="100" step="0.01"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('discount_percentage') border-red-500 @enderror"
                                           placeholder="e.g., 20">
                                    @error('discount_percentage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Discount Amount -->
                                <div>
                                    <label for="discount_amount" class="block text-sm font-medium text-gray-700 mb-2">Fixed Discount Amount ($)</label>
                                    <input type="number" name="discount_amount" id="discount_amount" value="{{ old('discount_amount', $offer->discount_amount) }}" 
                                           min="0" step="0.01"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('discount_amount') border-red-500 @enderror"
                                           placeholder="e.g., 50.00">
                                    @error('discount_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Minimum Order Amount -->
                                <div>
                                    <label for="minimum_order_amount" class="block text-sm font-medium text-gray-700 mb-2">Minimum Order Amount ($)</label>
                                    <input type="number" name="minimum_order_amount" id="minimum_order_amount" value="{{ old('minimum_order_amount', $offer->minimum_order_amount) }}" 
                                           min="0" step="0.01"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out @error('minimum_order_amount') border-red-500 @enderror"
                                           placeholder="e.g., 100.00">
                                    @error('minimum_order_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Note:</strong> Use either percentage OR fixed amount discount, not both. Leave minimum order amount empty if not required.
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
                                    <label for="coupon_code" class="block text-sm font-medium text-gray-700 mb-2">Coupon Code</label>
                                    <div class="flex">
                                        <input type="text" name="coupon_code" id="coupon_code" value="{{ old('coupon_code', $offer->coupon_code) }}" 
                                               class="flex-1 px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('coupon_code') border-red-500 @enderror"
                                               placeholder="e.g., STUDENT20">
                                        <button type="button" onclick="generateCouponCode()" 
                                                class="px-4 py-3 bg-purple-600 text-white border border-purple-600 rounded-r-lg hover:bg-purple-700 transition duration-150 ease-in-out">
                                            <i class="fas fa-magic"></i>
                                        </button>
                                    </div>
                                    @error('coupon_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Usage Limit -->
                                <div>
                                    <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">Usage Limit</label>
                                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $offer->usage_limit) }}" 
                                           min="0"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('usage_limit') border-red-500 @enderror"
                                           placeholder="e.g., 100 (leave empty for unlimited)">
                                    @error('usage_limit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                    <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date', $offer->start_date ? $offer->start_date->format('Y-m-d\TH:i') : '') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('start_date') border-red-500 @enderror">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                    <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date', $offer->end_date ? $offer->end_date->format('Y-m-d\TH:i') : '') }}" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-150 ease-in-out @error('end_date') border-red-500 @enderror">
                                    @error('end_date')
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
                                          placeholder="Enter the terms and conditions for this offer...">{{ old('terms_conditions', $offer->terms_conditions) }}</textarea>
                                @error('terms_conditions')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.offers.show', $offer) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-150 ease-in-out">
                                Cancel
                            </a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-3 px-8 rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-save mr-2"></i>Update Offer
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
            document.getElementById('coupon_code').value = result;
        }
    </script>
</x-admin-layout>