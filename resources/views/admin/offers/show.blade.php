<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Offer Details: ') . $offer->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.offers.edit', $offer) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-edit mr-2"></i>Edit Offer
                </a>
                <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out"
                            onclick="return confirm('Are you sure you want to delete {{ $offer->title }}? This action cannot be undone.')">
                        <i class="fas fa-trash mr-2"></i>Delete Offer
                    </button>
                </form>
                <a href="{{ route('admin.offers.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Offers
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Offer Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Offer Header Card -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="relative h-48 bg-gradient-to-br 
                            @if($offer->type === 'discount') from-purple-500 to-purple-700
                            @elseif($offer->type === 'bogo') from-green-500 to-green-700
                            @elseif($offer->type === 'seasonal') from-orange-500 to-red-600
                            @elseif($offer->type === 'bundle') from-blue-500 to-blue-700
                            @else from-indigo-500 to-purple-600 @endif">
                            
                            <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <div class="mb-3">
                                        @if($offer->type === 'discount')
                                            <i class="fas fa-percentage text-6xl opacity-75"></i>
                                        @elseif($offer->type === 'bogo')
                                            <i class="fas fa-gift text-6xl opacity-75"></i>
                                        @elseif($offer->type === 'seasonal')
                                            <i class="fas fa-calendar-alt text-6xl opacity-75"></i>
                                        @elseif($offer->type === 'bundle')
                                            <i class="fas fa-box text-6xl opacity-75"></i>
                                        @else
                                            <i class="fas fa-tags text-6xl opacity-75"></i>
                                        @endif
                                    </div>
                                    @if($offer->discount_percentage)
                                        <div class="text-5xl font-black mb-2">{{ $offer->discount_percentage }}%</div>
                                        <div class="text-xl font-semibold uppercase tracking-wide">OFF</div>
                                    @elseif($offer->discount_amount)
                                        <div class="text-5xl font-black mb-2">${{ number_format($offer->discount_amount, 2) }}</div>
                                        <div class="text-xl font-semibold uppercase tracking-wide">OFF</div>
                                    @else
                                        <div class="text-3xl font-bold uppercase tracking-wide">Special Offer</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Offer Type Badge -->
                            <div class="absolute top-4 right-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wide bg-white bg-opacity-20 text-white">
                                    {{ strtoupper($offer->type) }}
                                </span>
                            </div>

                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    @if($offer->status === 'active') bg-green-100 text-green-800
                                    @elseif($offer->status === 'expired') bg-red-100 text-red-800
                                    @elseif($offer->status === 'scheduled') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($offer->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <h1 class="text-2xl font-bold text-gray-900 mb-3">{{ $offer->title }}</h1>
                            <p class="text-gray-700 leading-relaxed mb-4">{{ $offer->description }}</p>
                            
                            @if($offer->coupon_code)
                                <div class="mb-4 p-4 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-sm font-medium text-gray-600 uppercase block">Coupon Code</span>
                                            <span class="text-2xl font-black text-gray-900 tracking-wider">{{ $offer->coupon_code }}</span>
                                        </div>
                                        <button onclick="copyToClipboard('{{ $offer->coupon_code }}')" 
                                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                                            <i class="fas fa-copy mr-2"></i>Copy
                                        </button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Offer Details -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Offer Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                        <span class="text-sm font-medium text-gray-700">Offer Type</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($offer->type === 'discount') bg-purple-100 text-purple-800
                                            @elseif($offer->type === 'bogo') bg-green-100 text-green-800
                                            @elseif($offer->type === 'seasonal') bg-orange-100 text-orange-800
                                            @elseif($offer->type === 'bundle') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($offer->type) }}
                                        </span>
                                    </div>

                                    @if($offer->discount_percentage)
                                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-700">Discount Percentage</span>
                                            <span class="text-lg font-bold text-green-600">{{ $offer->discount_percentage }}%</span>
                                        </div>
                                    @endif

                                    @if($offer->discount_amount)
                                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-700">Fixed Discount</span>
                                            <span class="text-lg font-bold text-green-600">${{ number_format($offer->discount_amount, 2) }}</span>
                                        </div>
                                    @endif

                                    @if($offer->minimum_order_amount)
                                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-700">Minimum Order</span>
                                            <span class="text-sm text-gray-900">${{ number_format($offer->minimum_order_amount, 2) }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-4">
                                    @if($offer->usage_limit)
                                        <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                            <span class="text-sm font-medium text-gray-700">Usage Limit</span>
                                            <span class="text-sm text-gray-900">{{ number_format($offer->usage_limit) }} uses</span>
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                        <span class="text-sm font-medium text-gray-700">Start Date</span>
                                        <span class="text-sm text-gray-900">{{ $offer->start_date->format('M d, Y g:i A') }}</span>
                                    </div>

                                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                        <span class="text-sm font-medium text-gray-700">End Date</span>
                                        <span class="text-sm text-gray-900">{{ $offer->end_date->format('M d, Y g:i A') }}</span>
                                    </div>

                                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                        <span class="text-sm font-medium text-gray-700">Duration</span>
                                        <span class="text-sm text-gray-900">
                                            {{ $offer->start_date->diffInDays($offer->end_date) }} days
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions -->
                    @if($offer->terms_conditions)
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-file-contract text-orange-600 mr-2"></i>
                                    Terms & Conditions
                                </h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-sm text-gray-700 leading-relaxed">{{ $offer->terms_conditions }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Offer Statistics</h3>
                            <div class="space-y-4">
                                <div class="text-center p-4 bg-indigo-50 rounded-lg">
                                    <div class="text-3xl font-bold text-indigo-600 mb-1">0</div>
                                    <div class="text-sm text-gray-600">Total Uses</div>
                                </div>
                                
                                @if($offer->usage_limit)
                                    <div class="text-center p-4 bg-green-50 rounded-lg">
                                        <div class="text-3xl font-bold text-green-600 mb-1">{{ $offer->usage_limit }}</div>
                                        <div class="text-sm text-gray-600">Usage Limit</div>
                                    </div>
                                @endif

                                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                                    <div class="text-3xl font-bold text-yellow-600 mb-1">
                                        {{ $offer->start_date->diffInDays($offer->end_date) }}
                                    </div>
                                    <div class="text-sm text-gray-600">Days Duration</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Offer Timeline -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Offer Timeline</h3>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-play text-green-600 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Offer Starts</p>
                                        <p class="text-sm text-gray-500">{{ $offer->start_date->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-stop text-red-600 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Offer Ends</p>
                                        <p class="text-sm text-gray-500">{{ $offer->end_date->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-calendar text-blue-600 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">Created</p>
                                        <p class="text-sm text-gray-500">{{ $offer->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>

                                @if($offer->updated_at->ne($offer->created_at))
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-edit text-yellow-600 text-xs"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">Last Updated</p>
                                            <p class="text-sm text-gray-500">{{ $offer->updated_at->format('M d, Y g:i A') }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Offer Status Card -->
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Current Status</h3>
                            <div class="text-center">
                                <div class="inline-flex items-center px-4 py-2 rounded-full text-lg font-semibold
                                    @if($offer->status === 'active') bg-green-100 text-green-800
                                    @elseif($offer->status === 'expired') bg-red-100 text-red-800
                                    @elseif($offer->status === 'scheduled') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    @if($offer->status === 'active')
                                        <i class="fas fa-check-circle mr-2"></i>Active
                                    @elseif($offer->status === 'expired')
                                        <i class="fas fa-times-circle mr-2"></i>Expired
                                    @elseif($offer->status === 'scheduled')
                                        <i class="fas fa-clock mr-2"></i>Scheduled
                                    @else
                                        <i class="fas fa-pause-circle mr-2"></i>Inactive
                                    @endif
                                </div>
                                
                                @if($offer->status === 'active' && $offer->end_date->isFuture())
                                    <p class="text-sm text-gray-500 mt-2">
                                        Expires in {{ $offer->end_date->diffForHumans() }}
                                    </p>
                                @elseif($offer->status === 'scheduled' && $offer->start_date->isFuture())
                                    <p class="text-sm text-gray-500 mt-2">
                                        Starts {{ $offer->start_date->diffForHumans() }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Copy to Clipboard Script -->
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show a temporary success message
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
                toast.textContent = 'Coupon code copied to clipboard!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            });
        }
    </script>
</x-admin-layout>