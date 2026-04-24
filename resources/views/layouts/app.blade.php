<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Calorie Quest - @yield('title', 'Tracker')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            /* Mobile Safari fix for bottom nav */
            @supports (-webkit-touch-callout: none) {
                .pb-safe { padding-bottom: env(safe-area-inset-bottom, 20px); }
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 text-gray-800">
        
        <div class="min-h-screen md:flex md:flex-row pb-20 md:pb-0">
            <!-- Sidebar (Desktop) / Bottom Nav (Mobile) -->
            <nav class="fixed bottom-0 w-full bg-white/90 backdrop-blur-md border-t border-gray-200 z-50 md:w-64 md:border-r md:border-t-0 md:left-0 md:h-screen md:flex md:flex-col shadow-[0_-4px_10px_-1px_rgba(0,0,0,0.05)] md:shadow-none SafariMobile-pb-safe">
                
                <div class="md:flex md:flex-col md:p-6 md:h-full">
                    <!-- Logo Desktop only -->
                    <div class="hidden md:block text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500 mb-10 pt-4">
                        Calorie Quest
                    </div>

                    <!-- Links -->
                    <div class="flex justify-around items-center h-16 md:h-auto md:flex-col md:items-start md:space-y-6 md:mt-4 relative px-2">
                        
                        <a href="{{ route('dashboard') }}" class="flex flex-col md:flex-row items-center flex-1 md:flex-none justify-center w-full md:w-auto md:justify-start transition-colors {{ request()->routeIs('dashboard') ? 'text-purple-600 font-bold' : 'text-gray-400 hover:text-purple-500' }}">
                            <div class="{{ request()->routeIs('dashboard') ? 'bg-purple-100 p-1.5 md:p-2 rounded-xl text-purple-600' : 'p-1.5 md:p-2 text-gray-400' }} transition-colors">
                                <svg class="w-6 h-6 md:mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <span class="text-[10px] md:text-base mt-1 md:mt-0 font-medium tracking-wide">Quest Board</span>
                        </a>

                        <!-- Custom Floating Action Button style for Add Food -->
                        <a href="{{ route('food-logs.create') }}" class="relative -top-5 md:top-0 flex flex-col items-center justify-center bg-gradient-to-tr from-pink-500 to-purple-600 text-white w-14 h-14 rounded-full shadow-lg shadow-purple-200 hover:scale-105 transition-transform border-4 border-white md:border-none md:w-full md:rounded-2xl md:h-14 md:flex-row md:px-4 md:shadow-md md:justify-center">
                            <svg class="w-6 h-6 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            <span class="hidden md:inline font-bold tracking-wide">Log Food</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="flex flex-col md:flex-row items-center flex-1 md:flex-none justify-center w-full md:w-auto md:justify-start transition-colors {{ request()->routeIs('profile.edit') ? 'text-purple-600 font-bold' : 'text-gray-400 hover:text-purple-500' }}">
                            <div class="{{ request()->routeIs('profile.edit') ? 'bg-purple-100 p-1.5 md:p-2 rounded-xl text-purple-600' : 'p-1.5 md:p-2 text-gray-400' }} transition-colors">
                                <svg class="w-6 h-6 md:mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <span class="text-[10px] md:text-base mt-1 md:mt-0 font-medium tracking-wide">Profile</span>
                        </a>
                    </div>
                    
                    <div class="hidden md:block mt-auto text-sm text-gray-500 pt-8 border-t mb-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-red-500 flex items-center w-full font-medium transition-colors">
                                <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="flex-1 w-full md:pl-64">
                <!-- Mobile Header -->
                <header class="md:hidden bg-white shadow-sm border-b sticky top-0 z-40">
                    <div class="px-4 py-3 flex justify-between items-center">
                        <h1 class="text-xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-500">
                            Calorie Quest
                        </h1>
                    </div>
                </header>

                <div class="max-w-4xl mx-auto p-4 md:p-8 lg:p-10 pb-24 md:pb-10">
                    {{ $slot }}
                </div>
            </main>
        </div>

    </body>
</html>
