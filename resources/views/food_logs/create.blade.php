<x-app-layout>
    @section('title', 'Log Food')
    <div class="max-w-xl mx-auto mt-4 md:mt-10">
        
        <div class="mb-8 hidden md:block">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-bold text-gray-400 hover:text-purple-600 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Back to Quest Board
            </a>
        </div>

        <div class="bg-white rounded-[2rem] p-6 md:p-10 shadow-2xl shadow-pink-100/50 border border-gray-50 relative overflow-hidden">
            <!-- Decorative circle -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-gradient-to-bl from-pink-200 to-purple-200 rounded-full blur-3xl opacity-50 z-0"></div>

            <div class="relative z-10">
                <div class="flex items-center mb-8">
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-pink-200 mr-5 shrink-0 transform -rotate-6">
                        <svg class="w-8 h-8 transform rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">Log Your Food</h2>
                        <p class="text-gray-500 font-medium text-sm mt-1">Add a new entry to your daily quest.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('food-logs.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-1">
                        <label for="name" class="block text-xs font-extrabold text-gray-500 uppercase tracking-widest pl-1">Food Name</label>
                        <input id="name" name="name" type="text" placeholder="e.g. Nasi Goreng" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-400 focus:ring-purple-400 text-gray-800 font-medium px-5 py-4 transition-colors" required />
                        @error('name')<p class="text-red-500 text-xs font-bold pl-1 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-1">
                        <label for="calories" class="block text-xs font-extrabold text-gray-500 uppercase tracking-widest pl-1">Calories (kcal)</label>
                        <input id="calories" name="calories" type="number" placeholder="Enter amount" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-400 focus:ring-purple-400 text-gray-800 font-black text-xl px-5 py-4 transition-colors" required min="0" />
                        @error('calories')<p class="text-red-500 text-xs font-bold pl-1 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-1">
                        <label for="consumed_at" class="block text-xs font-extrabold text-gray-500 uppercase tracking-widest pl-1">Consumption Date</label>
                        <input id="consumed_at" name="consumed_at" type="date" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-400 focus:ring-purple-400 text-gray-700 font-medium px-5 py-4 transition-colors" required value="{{ date('Y-m-d') }}" />
                        @error('consumed_at')<p class="text-red-500 text-xs font-bold pl-1 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-1">
                        <label for="meal_type" class="block text-xs font-extrabold text-gray-500 uppercase tracking-widest pl-1">Meal Type</label>
                        <select id="meal_type" name="meal_type" class="block w-full rounded-2xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-400 focus:ring-purple-400 text-gray-800 font-medium px-5 py-4 transition-colors leading-tight" required>
                            <option value="breakfast">Breakfast</option>
                            <option value="lunch">Lunch</option>
                            <option value="dinner">Dinner</option>
                            <option value="snack" selected>Snack</option>
                        </select>
                        @error('meal_type')<p class="text-red-500 text-xs font-bold pl-1 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full relative flex items-center justify-center px-8 py-5 font-bold text-white bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl overflow-hidden shadow-xl shadow-purple-200 transition-transform hover:-translate-y-1 group">
                            <span class="absolute inset-0 w-full h-full bg-white opacity-0 group-hover:opacity-10 transition-opacity"></span>
                            <span class="text-lg tracking-wide">Submit Quest Log</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
