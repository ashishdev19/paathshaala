@extends('layouts.admin')

@section('title', 'Wallet Settings')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Wallet Settings</h1>

    <div class="bg-white rounded shadow p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.wallet.settings.update') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Minimum Withdraw Amount (INR)</label>
                <input type="number" name="min_withdraw_amount" value="{{ old('min_withdraw_amount', $settings['min_withdraw_amount'] ?? 500) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Platform Commission (%)</label>
                <input type="number" name="platform_commission" value="{{ old('platform_commission', $settings['platform_commission'] ?? 10) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Withdraw Fee (%)</label>
                <input type="number" name="withdraw_fee" value="{{ old('withdraw_fee', $settings['withdraw_fee'] ?? 2) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="hidden" name="enable_topup" value="0">
                    <input type="checkbox" name="enable_topup" value="1" {{ (old('enable_topup', $settings['enable_topup'] ?? true) ? 'checked' : '') }} class="form-checkbox">
                    <span class="ml-2">Enable Wallet Top-up</span>
                </label>
            </div>

            <div>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save Settings</button>
            </div>
        </form>
    </div>
</div>
@endsection
