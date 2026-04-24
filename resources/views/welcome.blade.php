<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calorie Quest - Welcome</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:400,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-800">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <!-- Left Side: Content -->
        <div class="w-full lg:w-1/2 flex flex-col bg-white relative z-10 px-8 py-12 lg:px-16 lg:py-24 xl:px-24">
            
            <div class="flex-1 flex flex-col justify-center animate-fade-in-up">
                <div class="inline-flex items-center space-x-2 bg-purple-50 text-purple-600 font-bold px-4 py-2 rounded-full text-sm w-max mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>Gamify Your Nutrition</span>
                </div>

                <h1 class="text-6xl md:text-7xl font-black text-gray-900 mb-6 leading-none tracking-tight">
                    Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500">Calorie Quest</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-500 font-medium mb-12 max-w-lg" style="animation-delay: 150ms;">
                    Level up your health journey. Track your calories, hit your daily targets, and build an unbreakable nutrition streak!
                </p>

                @if (Route::has('login'))
                    <div class="flex flex-col sm:flex-row gap-5" style="animation-delay: 300ms;">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl overflow-hidden shadow-lg shadow-purple-200 transition-all hover:-translate-y-1 hover:shadow-xl">
                                Go to Dashboard
                                <svg class="w-5 h-5 ml-2 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-4 font-bold text-gray-700 bg-gray-50 border border-gray-200 rounded-2xl hover:bg-gray-100 transition-colors text-center shadow-sm">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="group relative inline-flex items-center justify-center px-8 py-4 font-bold text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl overflow-hidden shadow-lg shadow-pink-200 transition-transform hover:-translate-y-1 hover:shadow-xl">
                                    Start Your Journey
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>

            <!-- Features -->
            <div class="mt-16 grid grid-cols-1 sm:grid-cols-2 gap-8 border-t border-gray-100 pt-10" style="animation-delay: 450ms;">
                <div class="animate-fade-in-up">
                    <div class="w-12 h-12 inline-flex items-center justify-center rounded-xl bg-purple-100 text-purple-600 mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Track Intakes</h3>
                    <p class="text-gray-500 text-sm font-medium pr-4">Log your food consumption swiftly with our frictionless interface.</p>
                </div>
                <div class="animate-fade-in-up" style="animation-delay: 150ms;">
                    <div class="w-12 h-12 inline-flex items-center justify-center rounded-xl bg-pink-100 text-pink-600 mb-4 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2 text-gray-800">Build Streaks</h3>
                    <p class="text-gray-500 text-sm font-medium pr-4">Every day under your limit counts towards your massive leveling streak.</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Image Cover (Hidden on Small Screens) -->
        <div class="hidden lg:block lg:w-1/2 relative bg-gray-900">
            <!-- Awesome imagery related to health/food -->
            <img class="absolute inset-0 w-full h-full object-cover opacity-90" src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=2000&auto=format&fit=crop" alt="Healthy Food Bowl">
            
            <!-- Soft Gradient Overlay to make it rich -->
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/30 via-pink-500/20 to-transparent mix-blend-overlay"></div>
            
            <!-- Floating element just for design flex -->
            <div class="absolute bottom-20 left-10 p-8 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 shadow-2xl text-white max-w-sm animate-fade-in-up"  style="animation-delay: 800ms;">
                <p class="text-2xl font-black mb-2">"Health is not a task, it's a quest."</p>
                <p class="text-white/80 font-medium">Join thousands tracking their goals flawlessly.</p>
            </div>
        </div>
    </div>
</body>
</html>
