<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Offers Management') }}
            </h2>
            <a href="{{ route('admin.offers.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Create New Offer
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Offers Analytics Dashboard -->
            <div class="mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Offers Card -->
                    <div class="relative overflow-hidden">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-tags text-white text-lg"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide">Total Offers</p>
                                        </div>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <p class="text-4xl font-black text-white mb-1">{{ number_format($offers->total()) }}</p>
                                        <div class="text-right">
                                            <p class="text-blue-100 text-xs font-medium">All promotional offers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white bg-opacity-10 rounded-full -mr-12 -mt-12"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-white bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
                        </div>
                    </div>

                    <!-- Active Offers Card -->
                    <div class="relative overflow-hidden">
                        <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-check-circle text-white text-lg"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-green-100 text-sm font-semibold uppercase tracking-wide">Active Offers</p>
                                        </div>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <p class="text-4xl font-black text-white mb-1">{{ number_format($offers->where('status', 'active')->count()) }}</p>
                                        <div class="text-right">
                                            <p class="text-green-100 text-xs font-medium">Currently available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white bg-opacity-10 rounded-full -mr-12 -mt-12"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-white bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
                        </div>
                    </div>

                    <!-- Discount Coupons Card -->
                    <div class="relative overflow-hidden">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-percentage text-white text-lg"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide">Discount Coupons</p>
                                        </div>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <p class="text-4xl font-black text-white mb-1">{{ number_format($offers->where('type', 'discount')->count()) }}</p>
                                        <div class="text-right">
                                            <p class="text-purple-100 text-xs font-medium">Percentage & fixed discounts</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white bg-opacity-10 rounded-full -mr-12 -mt-12"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-white bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
                        </div>
                    </div>

                    <!-- Special Offers Card -->
                    <div class="relative overflow-hidden">
                        <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl shadow-xl p-6 text-white transform hover:scale-105 transition-all duration-300">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                                            <i class="fas fa-star text-white text-lg"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-orange-100 text-sm font-semibold uppercase tracking-wide">Special Offers</p>
                                        </div>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <p class="text-4xl font-black text-white mb-1">{{ number_format($offers->whereIn('type', ['bogo', 'seasonal', 'bundle'])->count()) }}</p>
                                        <div class="text-right">
                                            <p class="text-orange-100 text-xs font-medium">BOGO, seasonal & bundles</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white bg-opacity-10 rounded-full -mr-12 -mt-12"></div>
                            <div class="absolute bottom-0 left-0 w-16 h-16 bg-white bg-opacity-10 rounded-full -ml-8 -mb-8"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Stats -->
            <div class="mb-8 bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">Quick Actions</h3>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.offers.create') }}" class="inline-flex items-center px-3 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="fas fa-plus mr-2"></i>New Offer
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offers Grid -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Promotional Offers Directory</h3>
                        <div class="flex items-center space-x-4">
                            <span class="text-sm text-gray-500">Showing {{ $offers->count() }} of {{ $offers->total() }} offers</span>
                        </div>
                    </div>
                </div>

                @if($offers->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($offers as $offer)
                                <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl border border-gray-200 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <!-- Offer Type Badge -->
                                    <div class="absolute top-4 right-4 z-10">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                            @if($offer->type === 'discount') bg-purple-100 text-purple-800
                                            @elseif($offer->type === 'bogo') bg-green-100 text-green-800
                                            @elseif($offer->type === 'seasonal') bg-orange-100 text-orange-800
                                            @elseif($offer->type === 'bundle') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ strtoupper($offer->type) }}
                                        </span>
                                    </div>

                                    <!-- Offer Header -->
                                    <div class="relative p-6 pb-4">
                                        <div class="flex items-start justify-between mb-3">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-bold text-gray-900 mb-2 pr-16">{{ $offer->title }}</h4>
                                                <p class="text-sm text-gray-600 line-clamp-2">{{ $offer->description }}</p>
                                            </div>
                                        </div>

                                        <!-- Offer Value -->
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center space-x-2">
                                                @if($offer->discount_percentage)
                                                    <span class="text-2xl font-black text-green-600">{{ $offer->discount_percentage }}%</span>
                                                    <span class="text-sm text-gray-500">OFF</span>
                                                @elseif($offer->discount_amount)
                                                    <span class="text-2xl font-black text-green-600">${{ number_format($offer->discount_amount, 2) }}</span>
                                                    <span class="text-sm text-gray-500">OFF</span>
                                                @else
                                                    <span class="text-lg font-bold text-indigo-600">Special Deal</span>
                                                @endif
                                            </div>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                @if($offer->status === 'active') bg-green-100 text-green-800
                                                @elseif($offer->status === 'expired') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800 @endif">
                                                {{ ucfirst($offer->status) }}
                                            </span>
                                        </div>

                                        <!-- Coupon Code -->
                                        @if($offer->coupon_code)
                                            <div class="mb-4 p-3 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-xs font-medium text-gray-600 uppercase">Coupon Code</span>
                                                    <button onclick="copyToClipboard('{{ $offer->coupon_code }}')" class="text-indigo-600 hover:text-indigo-800 text-xs">
                                                        <i class="fas fa-copy"></i>
                                                    </button>
                                                </div>
                                                <span class="text-lg font-black text-gray-900 tracking-wider">{{ $offer->coupon_code }}</span>
                                            </div>
                                        @endif

                                        <!-- Offer Details -->
                                        <div class="space-y-2 text-xs text-gray-600">
                                            @if($offer->minimum_order_amount)
                                                <div class="flex items-center">
                                                    <i class="fas fa-shopping-cart w-3 mr-2"></i>
                                                    <span>Min. order: ${{ number_format($offer->minimum_order_amount, 2) }}</span>
                                                </div>
                                            @endif
                                            @if($offer->usage_limit)
                                                <div class="flex items-center">
                                                    <i class="fas fa-users w-3 mr-2"></i>
                                                    <span>Usage limit: {{ $offer->usage_limit }}</span>
                                                </div>
                                            @endif
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar w-3 mr-2"></i>
                                                <span>Valid: {{ $offer->start_date->format('M d') }} - {{ $offer->end_date->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Offer Actions -->
                                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.offers.show', $offer) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                <i class="fas fa-eye mr-1"></i>View
                                            </a>
                                            <a href="{{ route('admin.offers.edit', $offer) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                <i class="fas fa-edit mr-1"></i>Edit
                                            </a>
                                        </div>
                                        <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" 
                                                    onclick="return confirm('Are you sure you want to delete this offer?')">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $offers->links() }}
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="mb-4">
                                <i class="fas fa-tags text-6xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Offers Created Yet</h3>
                            <p class="text-gray-500 mb-6">Get started by creating your first promotional offer for students.</p>
                            <a href="{{ route('admin.offers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                                <i class="fas fa-plus mr-2"></i>Create First Offer
                            </a>
                        </div>
                    </div>
                @endif
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
                toast.textContent = 'Coupon code copied!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 2000);
            });
        }
    </script>
</x-admin-layout>