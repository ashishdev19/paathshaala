<x-layouts.student>
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 montserrat">
                <i class="fas fa-gift text-teal-600 mr-3"></i>Referral Program
            </h1>
            <p class="text-gray-600 mt-2">Share your referral code and earn rewards when friends join!</p>
        </div>

        <!-- Pending Discount Alert (if user was referred) -->
        @if($pendingDiscount)
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 p-6 rounded-lg mb-8 shadow-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-600 text-3xl"></i>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-green-900">You Have a Referral Discount!</h3>
                    <p class="text-green-700 mt-1">
                        You have <strong>₹{{ number_format($pendingDiscount->referred_discount, 2) }}</strong> referral discount available! 
                        This will be automatically applied to your next course purchase.
                    </p>
                </div>
                <a href="{{ route('courses.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition-all ml-4">
                    <i class="fas fa-shopping-cart mr-2"></i>Browse Courses
                </a>
            </div>
        </div>
        @endif

        <!-- Wallet Credits Balance -->
        @if($wallet)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-6 rounded-lg mb-8 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-wallet text-blue-600 text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-900">Your Wallet Credits</h3>
                        <p class="text-blue-700 mt-1">
                            You have <strong class="text-2xl">₹{{ number_format($wallet->balance ?? 0, 2) }}</strong> in wallet credits
                        </p>
                        <p class="text-sm text-blue-600 mt-1">Earned from referrals</p>
                    </div>
                </div>
                @if(($wallet->balance ?? 0) > 0)
                <div class="text-right">
                    <p class="text-sm text-blue-600">Use your credits for:</p>
                    <p class="text-blue-700 font-semibold">✓ Course purchases</p>
                    <p class="text-blue-700 font-semibold">✓ Future enrollments</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Referral Code Card -->
        <div class="bg-gradient-to-br from-teal-600 to-teal-800 rounded-xl shadow-xl p-8 mb-8 text-white">
            <div class="text-center">
                @if($campaignName)
                <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2 inline-block mb-4">
                    <p class="text-sm font-semibold">
                        <i class="fas fa-star mr-2"></i>{{ $campaignName }}
                    </p>
                </div>
                @endif
                
                <h2 class="text-2xl font-bold mb-2">Your Referral Code</h2>
                <p class="text-teal-100 mb-6">Share this code with friends to earn ₹{{ number_format($referrerCredit, 0) }} for each signup!</p>
                
                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 inline-block min-w-[300px]">
                    <div class="text-5xl font-bold tracking-wider mb-4" id="referralCode">
                        {{ $referralCode->code }}
                    </div>
                    <button onclick="copyReferralCode()" class="bg-white text-teal-600 px-6 py-2 rounded-lg font-semibold hover:bg-teal-50 transition-all">
                        <i class="fas fa-copy mr-2"></i>Copy Code
                    </button>
                </div>

                <div class="mt-6">
                    <p class="text-teal-100 mb-3">Or share via link:</p>
                    <div class="flex gap-3 justify-center">
                        <button onclick="shareWhatsApp()" class="bg-green-500 hover:bg-green-600 px-6 py-2 rounded-lg font-semibold transition-all">
                            <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                        </button>
                        <button onclick="shareEmail()" class="bg-blue-500 hover:bg-blue-600 px-6 py-2 rounded-lg font-semibold transition-all">
                            <i class="fas fa-envelope mr-2"></i>Email
                        </button>
                        <button onclick="copyShareLink()" class="bg-indigo-500 hover:bg-indigo-600 px-6 py-2 rounded-lg font-semibold transition-all">
                            <i class="fas fa-link mr-2"></i>Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Earned</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['total_earned'], 2) }}</p>
                    </div>
                    <div class="bg-teal-100 p-4 rounded-full">
                        <i class="fas fa-rupee-sign text-teal-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- How It Works -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-question-circle text-teal-600 mr-2"></i>How It Works
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="bg-teal-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-share-alt text-teal-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">1. Share Your Code</h3>
                    <p class="text-gray-600">Share your unique referral code with friends and family.</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-plus text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">2. Friend Signs Up</h3>
                    <p class="text-gray-600">They register using your code and get ₹100 instant discount.</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-coins text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">3. You Earn Rewards</h3>
                    <p class="text-gray-600">When they make their first purchase, you get ₹100 wallet credit!</p>
                </div>
            </div>
        </div>

        <!-- Referral History -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-history text-teal-600 mr-2"></i>Referral History
            </h2>

            @if($referrals->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referred User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Your Credit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Their Discount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($referrals as $referral)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-teal-100 rounded-full flex items-center justify-center">
                                        <span class="text-teal-600 font-semibold">{{ substr($referral->referred->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $referral->referred->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $referral->referred->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $referral->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($referral->discount_applied)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Completed
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i> Pending Purchase
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($referral->credit_applied)
                                    <span class="text-green-600 font-semibold">₹{{ number_format($referral->referrer_credit, 2) }}</span>
                                @else
                                    <span class="text-gray-400">₹{{ number_format($referral->referrer_credit, 2) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ₹{{ number_format($referral->referred_discount, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $referrals->links() }}
            </div>
            @else
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Referrals Yet</h3>
                <p class="text-gray-500">Start sharing your referral code to earn rewards!</p>
            </div>
            @endif
        </div>
    </div>

    <script>
        const shareableLink = "{{ $shareableLink }}";
        const referralCode = "{{ $referralCode->code }}";

        function copyReferralCode() {
            navigator.clipboard.writeText(referralCode).then(() => {
                showToast('Referral code copied to clipboard!');
            });
        }

        function copyShareLink() {
            navigator.clipboard.writeText(shareableLink).then(() => {
                showToast('Referral link copied to clipboard!');
            });
        }

        function shareWhatsApp() {
            const text = `Join Medniks using my referral code ${referralCode} and get ₹100 instant discount! ${shareableLink}`;
            window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
        }

        function shareEmail() {
            const subject = 'Join Medniks and Get ₹100 Discount!';
            const body = `Hi!\n\nI'm inviting you to join Medniks, an amazing learning platform.\n\nUse my referral code: ${referralCode}\nOr click this link: ${shareableLink}\n\nYou'll get ₹100 instant discount on your first purchase!\n\nHappy Learning!`;
            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        }

        function showToast(message) {
            // Simple toast notification (you can replace with your toast library)
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-4 right-4 bg-teal-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            toast.innerHTML = `<i class="fas fa-check-circle mr-2"></i>${message}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }
    </script>
</x-layouts.student>
