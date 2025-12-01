@extends('layouts.admin')

@section('title', 'All Wallets')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">All User Wallets</h1>

    <div class="bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3">User</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Balance</th>
                    <th class="px-6 py-3">Reserved</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wallets as $wallet)
                    <tr>
                        <td class="px-6 py-4">{{ optional($wallet->user)->name }}</td>
                        <td class="px-6 py-4">{{ optional($wallet->user)->email }}</td>
                        <td class="px-6 py-4">₹{{ number_format($wallet->balance,2) }}</td>
                        <td class="px-6 py-4">₹{{ number_format($wallet->reserved_amount,2) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.wallet.user-wallet', $wallet->user_id) }}" class="text-indigo-600">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">{{ $wallets->links() ?? '' }}</div>
    </div>
</div>
@endsection
