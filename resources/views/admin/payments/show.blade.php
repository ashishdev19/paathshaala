<x-layouts.admin>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Payment Details
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <!-- Payment Overview Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Transaction Details</h3>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        @if($payment->status == 'completed') bg-green-100 text-green-800
                        @elseif($payment->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($payment->status == 'failed') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Transaction ID</label>
                        <p class="text-lg font-mono text-gray-900">{{ $payment->transaction_id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Payment Date</label>
                        <p class="text-lg text-gray-900">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Payment Method</label>
                        <p class="text-lg text-gray-900">{{ ucfirst($payment->payment_method ?? 'Online') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Payment Gateway</label>
                        <p class="text-lg text-gray-900">{{ ucfirst($payment->payment_gateway ?? 'Razorpay') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Information -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Student Information</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 rounded-full bg-indigo-500 flex items-center justify-center text-white font-semibold text-xl">
                        {{ strtoupper(substr($payment->student->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-lg font-semibold text-gray-900">{{ $payment->student->name ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->student->email ?? '' }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Phone</label>
                        <p class="text-gray-900">{{ $payment->student->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Student ID</label>
                        <p class="text-gray-900">#{{ $payment->student->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Information -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Course Information</h3>
            </div>
            <div class="p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-2">{{ $payment->course->title ?? 'N/A' }}</h4>
                <p class="text-sm text-gray-600 mb-4">{{ $payment->course->description ?? '' }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Instructor</label>
                        <p class="text-gray-900">{{ $payment->course->teacher->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Course ID</label>
                        <p class="text-gray-900">#{{ $payment->course->id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Breakdown -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Payment Breakdown</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Course Price</span>
                        <span class="text-gray-900 font-medium">₹{{ number_format($payment->amount, 2) }}</span>
                    </div>
                    @if($payment->discount_amount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount Applied</span>
                        <span class="font-medium">- ₹{{ number_format($payment->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    @if($payment->tax_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax ({{ $payment->tax_percentage ?? 18 }}%)</span>
                        <span class="text-gray-900 font-medium">₹{{ number_format($payment->tax_amount, 2) }}</span>
                    </div>
                    @endif
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="text-lg font-semibold text-gray-900">Total Amount Paid</span>
                        <span class="text-2xl font-bold text-indigo-600">₹{{ number_format($payment->final_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center">
            <a href="{{ route('admin.payments.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Payments
            </a>
            <div class="space-x-4">
                <button onclick="window.print()" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200">
                    Print Receipt
                </button>
                @if($payment->status == 'pending')
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Mark as Completed
                </button>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
