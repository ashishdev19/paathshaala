<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Receipt - {{ $payment->transaction_id }} - Paathshaala</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <h1 class="text-2xl font-bold text-indigo-600">Paathshaala</h1>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        Welcome, {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Receipt Header -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <!-- Header -->
                <div class="bg-indigo-600 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Payment Receipt</h1>
                            <p class="text-indigo-100">Transaction ID: {{ $payment->transaction_id }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-white text-sm">Date</div>
                            <div class="text-white font-semibold">{{ $payment->payment_date->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Receipt Body -->
                <div class="p-6">
                    <!-- Status Badge -->
                    <div class="mb-6">
                        @if($payment->status === 'completed')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Payment Successful
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                {{ ucfirst($payment->status) }}
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Student Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-600">Name</div>
                                    <div class="text-gray-900 font-medium">{{ $payment->student->name }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Email</div>
                                    <div class="text-gray-900">{{ $payment->student->email }}</div>
                                </div>
                                @if($payment->student->phone)
                                <div>
                                    <div class="text-sm text-gray-600">Phone</div>
                                    <div class="text-gray-900">{{ $payment->student->phone }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Details</h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-600">Payment Method</div>
                                    <div class="text-gray-900 font-medium">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Transaction ID</div>
                                    <div class="text-gray-900 font-mono">{{ $payment->transaction_id }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Payment Date</div>
                                    <div class="text-gray-900">{{ $payment->payment_date->format('F d, Y \a\t h:i A') }}</div>
                                </div>
                                @if($payment->payment_details)
                                    @php $details = json_decode($payment->payment_details, true); @endphp
                                    @if(isset($details['card_last_four']))
                                    <div>
                                        <div class="text-sm text-gray-600">Card</div>
                                        <div class="text-gray-900">**** **** **** {{ $details['card_last_four'] }}</div>
                                    </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Course Information -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Course Details</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-sm font-medium">{{ substr($payment->course->category, 0, 3) }}</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $payment->course->title }}</h4>
                                    <p class="text-gray-600 mb-2">by {{ $payment->course->teacher->name }}</p>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span>{{ $payment->course->duration }} hours</span>
                                        <span>{{ $payment->course->category }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-indigo-600">₹{{ number_format($payment->amount) }}</div>
                                    <div class="text-sm text-gray-500">Course Fee</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Course Fee</span>
                                    <span class="text-gray-900">₹{{ number_format($payment->amount) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-900">₹0</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Discount</span>
                                    <span class="text-gray-900">₹0</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-2">
                                    <div class="flex justify-between text-lg font-semibold">
                                        <span class="text-gray-900">Total Paid</span>
                                        <span class="text-indigo-600">₹{{ number_format($payment->amount) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button onclick="window.print()" 
                                class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                            Print Receipt
                        </button>
                        <a href="{{ route('student.courses.show', $payment->course->id) }}" 
                           class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-300 text-center">
                            Go to Course
                        </a>
                        <a href="{{ route('student.payments') }}" 
                           class="text-indigo-600 hover:text-indigo-800 px-6 py-3 font-semibold text-center">
                            View All Payments
                        </a>
                    </div>

                    <!-- Footer Note -->
                    <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                        <p class="text-gray-500 text-sm">
                            This is a computer-generated receipt. For any queries, please contact our support team.
                        </p>
                        <div class="mt-2 space-x-4 text-sm">
                            <span class="text-gray-400">Email: info@paathshaala.com</span>
                            <span class="text-gray-400">Phone: +91 9876543210</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body { 
                background: white !important; 
            }
            nav, .no-print { 
                display: none !important; 
            }
            .shadow, .rounded-lg { 
                box-shadow: none !important; 
                border: 1px solid #e5e5e5 !important; 
            }
        }
    </style>
</body>
</html>