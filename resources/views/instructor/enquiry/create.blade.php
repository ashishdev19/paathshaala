@extends('layouts.app')

@section('title', 'Teacher Registration')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Become an Instructor</h1>
            <p class="text-lg text-gray-600">Join our community of expert teachers and share your knowledge</p>
        </div>

        <!-- Registration Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="font-semibold text-red-800 mb-2">Please fix the following errors:</h3>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teacher.enquiry.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('full_name') border-red-500 @enderror">
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span class="text-red-500">*</span></label>
                    <input type="tel" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number') border-red-500 @enderror">
                    @error('phone_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qualification -->
                <div>
                    <label for="qualification" class="block text-sm font-semibold text-gray-700 mb-2">Qualification <span class="text-red-500">*</span></label>
                    <input type="text" id="qualification" name="qualification" value="{{ old('qualification') }}" placeholder="e.g., B.Sc., M.Tech., Ph.D." required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('qualification') border-red-500 @enderror">
                    @error('qualification')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Experience -->
                <div>
                    <label for="experience" class="block text-sm font-semibold text-gray-700 mb-2">Years of Experience <span class="text-red-500">*</span></label>
                    <input type="number" id="experience" name="experience" value="{{ old('experience') }}" min="0" max="70" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('experience') border-red-500 @enderror">
                    @error('experience')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject Expertise -->
                <div>
                    <label for="subject_expertise" class="block text-sm font-semibold text-gray-700 mb-2">Subject Expertise <span class="text-red-500">*</span></label>
                    <textarea id="subject_expertise" name="subject_expertise" rows="3" placeholder="e.g., Mathematics, Physics, Biology" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('subject_expertise') border-red-500 @enderror">{{ old('subject_expertise') }}</textarea>
                    @error('subject_expertise')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">About You <span class="text-red-500">*</span></label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Tell us about yourself, your teaching philosophy, and what makes you a great instructor..." required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bio') border-red-500 @enderror">{{ old('bio') }}</textarea>
                    @error('bio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plan Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Select a Subscription Plan <span class="text-red-500">*</span></label>
                    <div class="space-y-2">
                        @forelse($plans as $plan)
                            <label class="flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 @error('plan_id') border-red-500 @enderror">
                                <input type="radio" name="plan_id" value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'checked' : '' }} required class="mr-3">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-900">{{ $plan->name }}</div>
                                    <div class="text-sm text-gray-600">₹{{ number_format($plan->price, 0) }}/month</div>
                                </div>
                            </label>
                        @empty
                            <p class="text-gray-500">No plans available</p>
                        @endforelse
                    </div>
                    @error('plan_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms Acceptance -->
                <div class="flex items-start">
                    <input type="checkbox" id="agree_terms" name="agree_terms" {{ old('agree_terms') ? 'checked' : '' }} required class="mt-1 rounded @error('agree_terms') border-red-500 @enderror">
                    <label for="agree_terms" class="ml-3 text-sm text-gray-700">
                        I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a> <span class="text-red-500">*</span>
                    </label>
                </div>
                @error('agree_terms')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-check mr-2"></i> Submit Application
                </button>
            </form>

            <!-- Help Text -->
            <div class="mt-8 pt-8 border-t text-center">
                <p class="text-gray-600 text-sm">Already registered? <a href="{{ route('teacher.enquiry.status') }}" class="text-blue-600 hover:underline">Check your application status</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
