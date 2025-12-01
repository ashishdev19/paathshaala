<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Wallet Dashboard
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        <!-- Wallet Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-6 border border-indigo-200 shadow-md hover:shadow-lg transition duration-300">
                <div class="text-sm text-gray-600 mb-2">Total Wallets</div>
                <div class="text-3xl font-bold text-indigo-600">{{ number_format($stats['total_wallets'] ?? 0) }}</div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200 shadow-md hover:shadow-lg transition duration-300">
                <div class="text-sm text-gray-600 mb-2">Total Balance</div>
                <div class="text-3xl font-bold text-green-600">₹{{ number_format($stats['total_balance'] ?? 0, 2) }}</div>
            </div>

            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-6 border border-yellow-200 shadow-md hover:shadow-lg transition duration-300">
                <div class="text-sm text-gray-600 mb-2">Pending Withdrawals</div>
                <div class="text-3xl font-bold text-yellow-600">{{ number_format($stats['pending_withdrawals'] ?? 0) }}</div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow-lg border border-indigo-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-indigo-100">
                <h3 class="text-lg font-semibold text-indigo-900">Recent Transactions</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-indigo-900 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentTransactions ?? [] as $tx)
                            <tr class="hover:bg-indigo-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ optional($tx->wallet->user)->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $tx->type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($tx->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                                    {{ $tx->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $tx->type === 'credit' ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $tx->created_at->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No transactions yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.admin>
