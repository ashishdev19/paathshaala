@extends('layouts.app')

@section('title', 'Teacher Registration')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <i class="fas fa-exclamation-circle fa-4x text-yellow-500 mb-4"></i>
            <h1 class="text-4xl font-bold text-gray-900 mb-2">No Application Found</h1>
            <p class="text-lg text-gray-600">You haven't submitted a teacher registration application yet.</p>
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-3">Getting Started</h2>
                <p class="text-gray-700 mb-4">
                    To become an instructor on our platform, please submit your registration application. Our team will review your qualifications and get back to you within 2-3 business days.
                </p>
                <ul class="space-y-2 text-gray-700">
                    <li><i class="fas fa-check text-green-600 mr-2"></i> Share your qualifications and expertise</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i> Tell us about your teaching experience</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i> Choose your subscription plan</li>
                    <li><i class="fas fa-check text-green-600 mr-2"></i> Get approved and start teaching</li>
                </ul>
            </div>

            <!-- Action Button -->
            <div class="text-center">
                <a href="{{ route('teacher.enquiry.create') }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    <i class="fas fa-pen-square mr-2"></i> Submit Application Now
                </a>
            </div>

            <!-- Help Section -->
            <div class="mt-8 pt-8 border-t">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Frequently Asked Questions</h3>
                <div class="space-y-4">
                    <details class="border border-gray-200 rounded-lg p-4">
                        <summary class="font-semibold text-gray-900 cursor-pointer">How long does the review process take?</summary>
                        <p class="text-gray-700 mt-2">Typically, we review applications within 2-3 business days. You'll receive an email notification about the status.</p>
                    </details>
                    <details class="border border-gray-200 rounded-lg p-4">
                        <summary class="font-semibold text-gray-900 cursor-pointer">What qualifications do I need?</summary>
                        <p class="text-gray-700 mt-2">You should have relevant educational qualifications (bachelor's degree or higher) and preferably some teaching experience.</p>
                    </details>
                    <details class="border border-gray-200 rounded-lg p-4">
                        <summary class="font-semibold text-gray-900 cursor-pointer">Can I change my plan later?</summary>
                        <p class="text-gray-700 mt-2">Yes, you can upgrade or downgrade your subscription plan anytime from your instructor dashboard.</p>
                    </details>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
