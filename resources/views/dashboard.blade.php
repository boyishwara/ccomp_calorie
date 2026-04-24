<x-app-layout>
    @section('title', 'Quest Board')


    <div class="space-y-8 mt-2">
        
        <!-- WARNING ALERT if over calorie -->
        @if($isOverCalorie)
        <div class="animate-fade-in-up bg-red-50 border-2 border-red-500/50 rounded-2xl p-4 flex items-center shadow-lg shadow-red-100 relative overflow-hidden">
            <div class="absolute inset-0 bg-red-500/10 animate-pulse"></div>
            <div class="relative z-10 flex text-red-800 w-full items-center">
                <svg class="w-8 h-8 mr-3 text-red-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h3 class="font-extrabold text-red-700">WARNING: Target Exceeded!</h3>
                    <p class="text-sm font-medium">You have consumed {{ number_format($consumedToday - $target) }} kcal over your daily goal.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Player Stats Card -->
        <div class="animate-fade-in-up bg-white rounded-3xl shadow-xl shadow-purple-100/30 flex flex-col md:flex-row items-center relative overflow-hidden">
            <!-- Premium Background Image -->
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 sepia-[.2]" />
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/90 to-transparent"></div>
            
            <div class="flex-1 text-center md:text-left z-10 w-full mb-6 md:mb-0 p-6 md:p-8">
                <h2 class="text-2xl md:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-700 to-indigo-600 flex items-center justify-center md:justify-start gap-2">
                    Hello, {{ auth()->user()->name }}
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </h2>
                <div class="inline-flex items-center space-x-2 bg-gray-50 border border-gray-100 text-gray-700 font-semibold px-4 py-2 rounded-2xl text-sm shadow-sm mt-4">
                    <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span>Target: <span class="text-purple-600 font-black">{{ number_format($target) }}</span> kcal</span>
                </div>
            </div>

            <!-- Circular Progress -->
            <div class="relative z-10 shrink-0 bg-white/80 backdrop-blur-sm rounded-full p-2 mr-0 md:mr-8 mb-6 md:mb-0 shadow-lg shadow-purple-100 mix-blend-luminosity">
                <svg class="w-36 h-36 transform -rotate-90">
                    <circle cx="72" cy="72" r="62" fill="none" class="stroke-gray-100" stroke-width="12"></circle>
                    <circle cx="72" cy="72" r="62" fill="none" class="{{ $strokeClass }} transition-all duration-1000 ease-out" stroke-width="12" stroke-dasharray="389.5" stroke-dashoffset="{{ 389.5 - (389.5 * $percentage / 100) }}" stroke-linecap="round"></circle>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black {{ $colorClass }} drop-shadow-sm">{{ number_format($consumedToday) }}</span>
                    <span class="text-[10px] text-gray-500 font-extrabold flex items-center mt-1 uppercase tracking-widest">
                        Kcal
                    </span>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="animate-slide-in-bottom bg-white border-l-4 border-green-500 text-gray-700 px-6 py-4 rounded-2xl flex items-center justify-between shadow-lg shadow-green-100/50">
            <div class="flex items-center font-bold text-green-700">
                <svg class="w-6 h-6 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- LEFT COLUMN: Today's Breakdown & Logs -->
            <div class="space-y-6 flex flex-col">
                <!-- Meal Breakdown -->
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        Today's Breakdown
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach(['breakfast' => 'Breakfast', 'lunch' => 'Lunch', 'dinner' => 'Dinner', 'snack' => 'Snacks'] as $key => $label)
                        <div class="bg-gray-50 rounded-2xl p-4 flex flex-col justify-between">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ $label }}</span>
                            <span class="text-xl font-black text-gray-800 mt-1">{{ number_format($breakdown[$key]) }} <span class="text-[10px] text-gray-400 font-bold uppercase">kcal</span></span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Today's Logs -->
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-4 px-1">
                        <h3 class="text-xl font-bold text-gray-800">Today's Logs</h3>
                    </div>
                    
                    @if($todayLogs->isEmpty())
                        <div class="animate-fade-in-up bg-white rounded-3xl p-8 border-2 border-dashed border-purple-100 text-center shadow-sm">
                            <svg class="w-12 h-12 mx-auto text-purple-200 mb-3 animate-blob" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <p class="text-gray-500 font-semibold mb-4 text-sm">No food logged today.</p>
                            <a href="{{ route('food-logs.create') }}" class="px-5 py-2.5 font-bold text-white bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full shadow-lg shadow-purple-200 hover:scale-105 transition-transform inline-block text-sm">
                                Add Log
                            </a>
                        </div>
                    @else
                        <div class="space-y-3">
                            @foreach($todayLogs as $log)
                                <div x-data="{ open: false }" class="opacity-0 animate-fade-in-up bg-white rounded-2xl p-3 shadow-sm border border-gray-100 hover:-translate-y-1 hover:shadow-md hover:shadow-purple-100/50 transition-all duration-300 relative overflow-hidden group" style="animation-delay: {{ $loop->index * 100 }}ms;">
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-purple-400 to-pink-500"></div>
                                    <div class="flex justify-between items-center pl-3">
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $log->name }}</h4>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md">{{ $log->meal_type }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right flex items-center gap-2">
                                            <div class="flex flex-col items-end">
                                                <span class="text-lg font-black text-transparent bg-clip-text bg-gradient-to-r from-gray-700 to-gray-900 leading-none">{{ $log->calories }}</span>
                                            </div>
                                            <button @click="open = !open" class="ml-1 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-full transition-colors focus:outline-none shrink-0">
                                                <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Expandable Edit/Delete section -->
                                    <div x-show="open" x-cloak class="mt-3 pt-3 border-t border-gray-100 pl-3">
                                        <div x-data="{ editing: false }">
                                            <div x-show="!editing" class="flex justify-end gap-2">
                                                <button type="button" @click="editing = true" class="text-xs px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl hover:bg-indigo-100 transition-colors font-bold">Edit</button>
                                                <form action="{{ route('food-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Abandon this quest log?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs px-4 py-2 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-colors font-bold">Delete</button>
                                                </form>
                                            </div>
                                            
                                            <form x-show="editing" method="POST" action="{{ route('food-logs.update', $log) }}" class="space-y-3 bg-gray-50 p-3 rounded-xl mt-2">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid grid-cols-1 gap-3">
                                                    <div>
                                                        <label class="text-[10px] font-bold tracking-wider text-gray-500 uppercase">Food Name</label>
                                                        <input name="name" type="text" class="mt-1 w-full text-sm border-gray-200 focus:border-purple-400 focus:ring-purple-400 rounded-xl shadow-sm" required value="{{ $log->name }}" />
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="text-[10px] font-bold tracking-wider text-gray-500 uppercase">Calories</label>
                                                            <input name="calories" type="number" class="mt-1 w-full text-sm border-gray-200 focus:border-purple-400 focus:ring-purple-400 rounded-xl shadow-sm" required value="{{ $log->calories }}" min="0"/>
                                                        </div>
                                                        <div>
                                                            <label class="text-[10px] font-bold tracking-wider text-gray-500 uppercase">Meal Type</label>
                                                            <select name="meal_type" class="mt-1 w-full text-sm border-gray-200 focus:border-purple-400 focus:ring-purple-400 rounded-xl shadow-sm" required>
                                                                <option value="breakfast" {{ $log->meal_type == 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                                                <option value="lunch" {{ $log->meal_type == 'lunch' ? 'selected' : '' }}>Lunch</option>
                                                                <option value="dinner" {{ $log->meal_type == 'dinner' ? 'selected' : '' }}>Dinner</option>
                                                                <option value="snack" {{ $log->meal_type == 'snack' ? 'selected' : '' }}>Snack</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="text-[10px] font-bold tracking-wider text-gray-500 uppercase">Date</label>
                                                        <input name="consumed_at" type="date" class="mt-1 w-full text-sm border-gray-200 focus:border-purple-400 focus:ring-purple-400 rounded-xl shadow-sm" required value="{{ $log->consumed_at->format('Y-m-d') }}" />
                                                    </div>
                                                </div>
                                                <div class="flex justify-end space-x-2 pt-1">
                                                    <button type="button" @click="editing = false" class="text-xs px-4 py-2 text-gray-500 hover:bg-gray-200 rounded-xl font-bold transition-colors">Cancel</button>
                                                    <button type="submit" class="text-xs px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl font-bold shadow-sm hover:scale-105 transition-transform">Save Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN: History -->
            <div>
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative">
                    <h3 class="font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Historical Progress
                    </h3>

                    <div class="space-y-6">
                        <!-- Yesterday -->
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-600">Yesterday</span>
                                <div class="text-right">
                                    <span class="text-lg font-black text-gray-800">{{ number_format($consumedYesterday) }}</span><span class="text-xs text-gray-400">/{{ number_format($target) }} kcal</span>
                                </div>
                            </div>
                            @php $yPct = min(100, round(($consumedYesterday / $target) * 100)); @endphp
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-1000 {{ $consumedYesterday > $target ? 'bg-red-500' : ($yPct >= 85 ? 'bg-yellow-400' : 'bg-green-500') }}" style="width: {{ $yPct }}%"></div>
                            </div>
                        </div>

                        <!-- 2 Days Ago -->
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-sm font-bold text-gray-600">{{ now()->subDays(2)->format('l, d M') }}</span>
                                <div class="text-right">
                                    <span class="text-lg font-black text-gray-800">{{ number_format($consumedTwoDaysAgo) }}</span><span class="text-xs text-gray-400">/{{ number_format($target) }} kcal</span>
                                </div>
                            </div>
                            @php $tPct = min(100, round(($consumedTwoDaysAgo / $target) * 100)); @endphp
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="h-3 rounded-full transition-all duration-1000 {{ $consumedTwoDaysAgo > $target ? 'bg-red-500' : ($tPct >= 85 ? 'bg-yellow-400' : 'bg-green-500') }}" style="width: {{ $tPct }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
