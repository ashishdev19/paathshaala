@extends('layouts.admin')

@section('title', 'User Wallet')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Wallet for {{ $user->name }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="p-4 bg-white rounded shadow">
            <h3 class="text-sm text-gray-500">Total Balance</h3>
            <p class="text-2xl font-semibold">₹{{ number_format($wallet->balance,2) }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <h3 class="text-sm text-gray-500">Available</h3>
            <p class="text-2xl font-semibold">₹{{ number_format($wallet->available_balance,2) }}</p>
        </div>
    </div>

    <h2 class="text-lg font-semibold mb-2">Transactions</h2>
    <div class="bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Amount</th>
                    <th class="px-6 py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $tx)
                    <tr>
                        <td class="px-6 py-4">{{ $tx->id }}</td>
                        <td class="px-6 py-4">{{ ucfirst($tx->type) }}</td>
                        <td class="px-6 py-4">₹{{ number_format($tx->amount,2) }}</td>
                        <td class="px-6 py-4">{{ $tx->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">{{ $transactions->links() ?? '' }}</div>
    </div>
</div>
@endsection
