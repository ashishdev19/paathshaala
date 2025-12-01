<x-layouts.student>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Enrollment Successful
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Success Icon -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full mb-4">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-2">Enrollment Successful!</h2>
                <p class="text-green-100">Your payment has been processed successfully</p>
            </div>

            <!-- Success Message -->
            <div class="p-8">
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
                @endif

                <div class="space-y-4 mb-8">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">You're all set!</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                You have been successfully enrolled in the course. You can now access all course materials and start learning.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Check your email</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                We've sent a confirmation email with your enrollment details and course access information.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Start Learning</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                Access your enrolled courses from the dashboard and begin your learning journey right away.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('student.enrollments.index') }}" 
                       class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition">
                        My Courses
                    </a>
                    <a href="{{ route('student.courses.index') }}" 
                       class="block text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition">
                        Browse More Courses
                    </a>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-semibold text-blue-900 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                What's Next?
            </h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">1.</span>
                    <span>Visit "My Courses" to access your enrolled course</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">2.</span>
                    <span>Complete your profile to get personalized recommendations</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">3.</span>
                    <span>Join live classes and interact with instructors</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-600 font-bold">4.</span>
                    <span>Track your progress and earn certificates upon completion</span>
                </li>
            </ul>
        </div>
    </div>
</x-layouts.student>
