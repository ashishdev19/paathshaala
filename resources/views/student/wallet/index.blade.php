<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            My Wallet
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Wallet Balance -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Wallet Balance</p>
                        <p class="text-3xl font-bold text-green-600">₹{{ number_format($wallet->balance, 2) }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Topups -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Top-ups</p>
                        <p class="text-3xl font-bold text-blue-600">₹{{ number_format($stats['total_topup'], 2) }}</p>
                    </div>
                    <svg class="w-12 h-12 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 2a1 1 0 01.894.553l1.659 3.318a1 1 0 00.894.553h3.668a1 1 0 01.707 1.707l-2.829 2.829a1 1 0 00-.306 1.118l1.659 3.318a1 1 0 01-1.414 1.414L10 12.236l-2.829 2.829a1 1 0 01-1.414-1.414l1.659-3.318a1 1 0 00-.306-1.118L4.034 8.131a1 1 0 01.707-1.707h3.668a1 1 0 00.894-.553l1.659-3.318A1 1 0 0112 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg shadow p-6 border border-orange-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Spent</p>
                        <p class="text-3xl font-bold text-orange-600">₹{{ number_format($stats['total_spent'], 2) }}</p>
                    </div>
                    <svg class="w-12 h-12 text-orange-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M19.5 10a.5.5 0 00-.5-.5h-1.362l-.165-1.652a.5.5 0 00-.986.164l.164 1.652H15.5a.5.5 0 000 1h1.362l.165 1.652a.5.5 0 00.986-.164l-.164-1.652H19a.5.5 0 00.5-.5zM8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- Pending Topups -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg shadow p-6 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pending Top-ups</p>
                        <p class="text-3xl font-bold text-yellow-600">₹{{ number_format($stats['pending_topups'], 2) }}</p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 11-2 0 1 1 0 012 0zm-1 5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('student.wallet.topup') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-medium">
                            <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Money
                        </a>
                        <a href="#" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-medium">
                            <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            Download Statement
                        </a>
                    </div>
                </div>

                <!-- Transactions History -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Transaction History</h3>
                    </div>

                    @if($transactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $transaction->created_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $transaction->description ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($transaction->type === 'credit') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                                        @if($transaction->type === 'credit') text-green-600
                                        @else text-red-600 @endif">
                                        @if($transaction->type === 'credit') + @else - @endif ₹{{ number_format($transaction->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₹{{ number_format($transaction->balance_after, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($transactions instanceof \Illuminate\Pagination\Paginator && $transactions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $transactions->links() }}
                    </div>
                    @endif
                    @else
                    <div class="text-center py-12">
                        <!-- <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg> -->
                        <p class="mt-4 text-gray-500">No transactions yet</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Top-ups Status -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top-ups Status</h3>
                    
                    @if($topups->count() > 0)
                    <div class="space-y-3">
                        @foreach($topups as $topup)
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-semibold text-gray-900">₹{{ number_format($topup->amount, 2) }}</span>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($topup->status === 'completed') bg-green-100 text-green-800
                                    @elseif($topup->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($topup->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">{{ $topup->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-6">No top-ups yet</p>
                    @endif
                </div>

                <!-- Helpful Info -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 mb-3">How to Use Your Wallet</h3>
                    <ul class="text-sm text-blue-800 space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Add money to your wallet anytime</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Use wallet balance to enroll in courses</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>View all transactions in history</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.student>
