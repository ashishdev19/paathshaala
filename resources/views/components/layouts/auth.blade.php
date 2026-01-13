<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Medniks') }} - @yield('title', 'Authentication')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .montserrat {
            font-family: 'Montserrat', sans-serif;
        }
        .auth-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Side - Form -->
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-20 xl:px-24">
            <div class="w-full max-w-md">
                <!-- Logo -->
                <div class="text-center mb-8">
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3 group">
                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300" style="background-color: #008080;">
                                <i class="fas fa-graduation-cap text-white text-2xl"></i>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full animate-pulse border-2 border-white"></div>
                        </div>
                        <div class="text-left">
                            <h1 class="text-2xl font-bold text-black montserrat">
                                {{ config('app.name', 'Medniks') }}
                            </h1>
                            <p class="text-xs text-black-100 font-medium">Medical Excellence</p>
                        </div>
                    </a>
                </div>
                
                <!-- Form Card -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    {{ $slot }}
                </div>
                
                <!-- Footer Links -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Image/Info -->
        <div class="hidden lg:flex lg:flex-1 auth-gradient relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
            </div>
            
            <div class="relative z-10 flex flex-col items-center justify-center w-full px-16 text-white">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold mb-3 montserrat">Join 1000+ Teams</h2>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 max-w-md">
                        <div class="mb-4">
                            <i class="fas fa-quote-left text-2xl text-white/60 mb-3"></i>
                        </div>
                        <p class="text-white/90 leading-relaxed mb-6 italic">
                            "Medniks streamlined our entire learning workflow. Setting up my account was effortless, and within minutes, we were connecting with top instructors and accessing premium courses."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                                <span class="text-lg font-bold">RJ</span>
                            </div>
                            <div>
                                <p class="font-semibold">Dr. Rajesh Joshi</p>
                                <p class="text-sm text-white/70">Medical Professional</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="w-full max-w-md">
                    <h3 class="text-center text-white/90 font-semibold mb-4 text-sm uppercase tracking-wider">Trusted by Professionals</h3>
                    <div class="grid grid-cols-4 gap-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-hospital text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">AIIMS</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-hospital-alt text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">Apollo</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-clinic-medical text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">Max</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-stethoscope text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">Fortis</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-heartbeat text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">Medanta</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-user-md text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">Manipal</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-briefcase-medical text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">ASTER</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3 flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-first-aid text-2xl text-white mb-1"></i>
                                <p class="text-xs text-white/80">Others</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
