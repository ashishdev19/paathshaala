@extends('layouts.admin')

@section('title', 'Withdraw Requests')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Withdraw Requests</h1>

    <div class="bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Teacher</th>
                    <th class="px-6 py-3">Amount</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Requested At</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($withdrawRequests as $req)
                    <tr>
                        <td class="px-6 py-4">{{ $req->id }}</td>
                        <td class="px-6 py-4">{{ optional($req->teacher)->name }}</td>
                        <td class="px-6 py-4">₹{{ number_format($req->amount,2) }}</td>
                        <td class="px-6 py-4">{{ ucfirst($req->status) }}</td>
                        <td class="px-6 py-4">{{ $req->requested_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.wallet.withdraw-requests.show', $req->id) }}" class="text-indigo-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4" colspan="6">No withdraw requests found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $withdrawRequests->links() ?? '' }}</div>
    </div>
</div>
@endsection
