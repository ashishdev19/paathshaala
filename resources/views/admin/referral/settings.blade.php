@extends('layouts.admin.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 montserrat">
            <i class="fas fa-gift text-teal-600 mr-3"></i>Referral System Settings
        </h1>
        <p class="text-gray-600 mt-2">Configure referral rewards and monitor referral activity</p>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
    @endif

    <!-- Active Campaign Banner -->
    @if(isset($settings['campaign_name']) && $settings['campaign_name']->value)
    <div class="bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl shadow-lg p-6 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="bg-white/20 backdrop-blur-sm rounded-full p-4">
                    <i class="fas fa-bullhorn text-3xl"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold">Active Campaign: {{ $settings['campaign_name']->value }}</h3>
                    @if(isset($settings['campaign_valid_from']) && $settings['campaign_valid_from']->value)
                    <p class="text-purple-100 mt-1">
                        <i class="fas fa-calendar mr-2"></i>
                        {{ \Carbon\Carbon::parse($settings['campaign_valid_from']->value)->format('d M Y') }}
                        @if(isset($settings['campaign_valid_until']) && $settings['campaign_valid_until']->value)
                            → {{ \Carbon\Carbon::parse($settings['campaign_valid_until']->value)->format('d M Y') }}
                        @endif
                    </p>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <p class="text-xl font-bold">₹{{ number_format($settings['referrer_credit_amount']->getTypedValue(), 0) }} Referrer</p>
                <p class="text-xl font-bold">₹{{ number_format($settings['referred_discount_amount']->getTypedValue(), 0) }} Discount</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Referrals</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_referrals'] }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Pending</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending_referrals'] }}</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Completed</p>
                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['completed_referrals'] }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Credits Given</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['total_credits_given'], 2) }}</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-wallet text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Discounts Given</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['total_discounts_given'], 2) }}</p>
                </div>
                <div class="bg-teal-100 p-4 rounded-full">
                    <i class="fas fa-tags text-teal-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Settings Form -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-cog text-teal-600 mr-2"></i>Referral Settings
            </h2>

            <form action="{{ route('admin.referral.settings.update') }}" method="POST">
                @csrf
                
                <!-- System Enable/Disable -->
                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="referral_enabled" value="1" 
                               {{ $settings['referral_enabled']->getTypedValue() ? 'checked' : '' }}
                               class="form-checkbox h-5 w-5 text-teal-600 rounded">
                        <span class="ml-3 text-gray-700 font-semibold">Enable Referral System</span>
                    </label>
                    <p class="text-gray-500 text-sm mt-1 ml-8">Turn referral system on or off globally</p>
                </div>

                <hr class="my-6">

                <!-- Campaign/Occasion Management -->
                <div class="mb-6 bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-lg border border-purple-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-calendar-star text-purple-600 mr-2"></i>Campaign Settings (Optional)
                    </h3>
                    
                    <div class="mb-4">
                        <label for="campaign_name" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-flag text-purple-500 mr-2"></i>Campaign/Occasion Name
                        </label>
                        <input type="text" name="campaign_name" id="campaign_name"
                               value="{{ $settings['campaign_name']->value ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                               placeholder="e.g., Diwali Special, New Year Offer, Summer Campaign">
                        <p class="text-gray-500 text-sm mt-1">Set a name for special occasion campaigns</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="campaign_valid_from" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-check text-green-500 mr-2"></i>Valid From
                            </label>
                            <input type="date" name="campaign_valid_from" id="campaign_valid_from"
                                   value="{{ $settings['campaign_valid_from']->value ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                        <div>
                            <label for="campaign_valid_until" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar-times text-red-500 mr-2"></i>Valid Until
                            </label>
                            <input type="date" name="campaign_valid_until" id="campaign_valid_until"
                                   value="{{ $settings['campaign_valid_until']->value ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        </div>
                    </div>
                    <p class="text-gray-500 text-sm mt-2">Leave dates blank for always-active campaign</p>
                </div>

                <!-- Referrer Credit Amount -->
                <div class="mb-6">
                    <label for="referrer_credit_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-coins text-purple-500 mr-2"></i>Referrer Credit Amount (₹)
                    </label>
                    <input type="number" step="0.01" name="referrer_credit_amount" id="referrer_credit_amount"
                           value="{{ $settings['referrer_credit_amount']->getTypedValue() }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                           required>
                    <p class="text-gray-500 text-sm mt-1">Amount credited to User A when User B signs up</p>
                </div>

                <!-- Referred Discount Amount -->
                <div class="mb-6">
                    <label for="referred_discount_amount" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag text-teal-500 mr-2"></i>Referred User Discount (₹)
                    </label>
                    <input type="number" step="0.01" name="referred_discount_amount" id="referred_discount_amount"
                           value="{{ $settings['referred_discount_amount']->getTypedValue() }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                           required>
                    <p class="text-gray-500 text-sm mt-1">Discount given to User B on signup</p>
                </div>

                <!-- Credit Timing -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-clock text-blue-500 mr-2"></i>When to Credit Referrer?
                    </label>
                    <div class="space-y-2">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="credit_on_signup" value="1"
                                   {{ $settings['credit_on_signup']->getTypedValue() ? 'checked' : '' }}
                                   class="form-radio h-4 w-4 text-teal-600">
                            <span class="ml-3 text-gray-700">Immediately on signup</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="credit_on_signup" value="0"
                                   {{ !$settings['credit_on_signup']->getTypedValue() ? 'checked' : '' }}
                                   class="form-radio h-4 w-4 text-teal-600">
                            <span class="ml-3 text-gray-700">After first purchase (recommended)</span>
                        </label>
                    </div>
                    <p class="text-gray-500 text-sm mt-1">Choose when User A receives their credit</p>
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 px-4 rounded-lg font-semibold transition-all">
                    <i class="fas fa-save mr-2"></i>Save Settings
                </button>
            </form>
        </div>

        <!-- Recent Referrals -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-history text-teal-600 mr-2"></i>Recent Referrals
                </h2>
                <a href="{{ route('admin.referral.list') }}" class="text-teal-600 hover:text-teal-700 font-semibold text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentReferrals->count() > 0)
            <div class="space-y-4">
                @foreach($recentReferrals as $referral)
                <div class="border-l-4 {{ $referral->discount_applied ? 'border-green-500' : 'border-yellow-500' }} bg-gray-50 p-4 rounded">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $referral->referrer->name }}</p>
                            <p class="text-sm text-gray-500">referred {{ $referral->referred->name }}</p>
                        </div>
                        @if($referral->discount_applied)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check"></i> Complete
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock"></i> Pending
                            </span>
                        @endif
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">{{ $referral->created_at->diffForHumans() }}</span>
                        <span class="text-teal-600 font-semibold">₹{{ number_format($referral->referrer_credit, 2) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <i class="fas fa-users text-gray-300 text-4xl mb-3"></i>
                <p class="text-gray-500">No referrals yet</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
