<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment Successful - Paathshaala</title>
    
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

    <div class="min-h-screen py-16">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Payment Successful!</h1>
                <p class="text-xl text-gray-600 mb-8">
                    You have successfully enrolled in the course. Welcome to your learning journey!
                </p>
                
                <!-- Course Info -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white text-sm font-medium">🎓</span>
                        </div>
                        <div class="text-left">
                            <h3 class="text-lg font-semibold text-gray-900">Course Enrollment Confirmed</h3>
                            <p class="text-gray-600">You can now access all course materials and join live classes</p>
                        </div>
                    </div>
                </div>
                
                <!-- Next Steps -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-blue-900 mb-4">What's Next?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-white text-xs font-bold">1</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-900">Access Your Course</h4>
                                <p class="text-blue-700 text-sm">Start learning immediately with our course materials</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-white text-xs font-bold">2</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-900">Join Live Classes</h4>
                                <p class="text-blue-700 text-sm">Participate in interactive sessions with experts</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-white text-xs font-bold">3</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-900">Track Progress</h4>
                                <p class="text-blue-700 text-sm">Monitor your learning journey on your dashboard</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="text-white text-xs font-bold">4</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-blue-900">Get Certified</h4>
                                <p class="text-blue-700 text-sm">Complete the course to earn your certificate</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-4">
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-block w-full bg-indigo-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                        Go to My Dashboard
                    </a>
                    
                    <a href="{{ route('student.courses') }}" 
                       class="inline-block w-full bg-gray-200 text-gray-800 py-3 px-8 rounded-lg font-semibold hover:bg-gray-300 transition duration-300">
                        View My Courses
                    </a>
                </div>
                
                <!-- Support Info -->
                <div class="mt-12 text-center">
                    <p class="text-gray-600 mb-4">Need help getting started?</p>
                    <div class="space-x-6">
                        <a href="{{ route('contact') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            Contact Support
                        </a>
                        <span class="text-gray-400">|</span>
                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">
                            View FAQs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confetti Animation -->
    <script>
        // Simple confetti effect
        function createConfetti() {
            const colors = ['#f43f5e', '#8b5cf6', '#06b6d4', '#10b981', '#f59e0b'];
            const confettiContainer = document.createElement('div');
            confettiContainer.style.position = 'fixed';
            confettiContainer.style.top = '0';
            confettiContainer.style.left = '0';
            confettiContainer.style.width = '100%';
            confettiContainer.style.height = '100%';
            confettiContainer.style.pointerEvents = 'none';
            confettiContainer.style.zIndex = '9999';
            document.body.appendChild(confettiContainer);

            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'absolute';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animationDuration = Math.random() * 3 + 2 + 's';
                confetti.style.animationName = 'fall';
                confetti.style.animationIterationCount = '1';
                confetti.style.animationFillMode = 'forwards';
                confettiContainer.appendChild(confetti);
            }

            // Remove confetti after animation
            setTimeout(() => {
                document.body.removeChild(confettiContainer);
            }, 5000);
        }

        // Add CSS animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fall {
                0% {
                    transform: translateY(-100vh) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(100vh) rotate(720deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Trigger confetti on page load
        window.addEventListener('load', createConfetti);
    </script>
</body>
</html>