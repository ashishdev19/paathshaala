@extends('layouts.admin')

@section('title', 'Withdraw Request Details')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Withdraw Request #{{ $withdrawRequest->id }}</h1>

    <div class="bg-white rounded shadow p-6">
        <p><strong>Teacher:</strong> {{ optional($withdrawRequest->teacher)->name }}</p>
        <p><strong>Amount:</strong> ₹{{ number_format($withdrawRequest->amount,2) }}</p>
        <p><strong>Fee:</strong> ₹{{ number_format($withdrawRequest->fee,2) }}</p>
        <p><strong>Net:</strong> ₹{{ number_format($withdrawRequest->net_amount,2) }}</p>
        <p><strong>Status:</strong> {{ ucfirst($withdrawRequest->status) }}</p>
        <p><strong>Requested At:</strong> {{ $withdrawRequest->requested_at->format('Y-m-d H:i') }}</p>

        <div class="mt-4 space-x-2">
            @if($withdrawRequest->isPending())
                <form action="{{ route('admin.wallet.withdraw-requests.approve', $withdrawRequest->id) }}" method="POST" class="inline">
                    @csrf
                    <button class="px-4 py-2 bg-green-600 text-white rounded">Approve</button>
                </form>
                <form action="{{ route('admin.wallet.withdraw-requests.reject', $withdrawRequest->id) }}" method="POST" class="inline">
                    @csrf
                    <button class="px-4 py-2 bg-red-600 text-white rounded">Reject</button>
                </form>
            @endif

            @if($withdrawRequest->isApproved())
                <form action="{{ route('admin.wallet.withdraw-requests.mark-paid', $withdrawRequest->id) }}" method="POST" class="inline">
                    @csrf
                    <input type="text" name="payout_reference" placeholder="Payout reference" class="border px-2 py-1" required>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Mark Paid</button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
