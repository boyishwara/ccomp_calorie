<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calorie Tracker Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add Food Log</h3>
                <form method="POST" action="{{ route('food-logs.store') }}" class="space-y-4 max-w-xl">
                    @csrf
                    <div>
                        <x-input-label for="name" :value="__('Food Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="calories" :value="__('Calories')" />
                        <x-text-input id="calories" name="calories" type="number" class="mt-1 block w-full" required min="0" />
                        <x-input-error :messages="$errors->get('calories')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="consumed_at" :value="__('Consumed Date')" />
                        <x-text-input id="consumed_at" name="consumed_at" type="date" class="mt-1 block w-full" required value="{{ date('Y-m-d') }}" />
                        <x-input-error :messages="$errors->get('consumed_at')" class="mt-2" />
                    </div>
                    <x-primary-button>{{ __('Add Log') }}</x-primary-button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Your Food Logs</h3>
                @if($foodLogs->isEmpty())
                    <p class="text-gray-600">No food logs found. Start adding some!</p>
                @else
                    <div class="space-y-4">
                        @foreach($foodLogs as $log)
                            <div x-data="{ editing: false }" class="border p-4 rounded-md">
                                <div x-show="!editing" class="flex justify-between items-center">
                                    <div>
                                        <p class="font-bold pb-1">{{ $log->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $log->calories }} Calories - {{ $log->consumed_at->format('M d, Y') }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button @click="editing = true" class="text-indigo-600 hover:text-indigo-900">Edit</button>
                                        <form method="POST" action="{{ route('food-logs.destroy', $log) }}" onsubmit="return confirm('Are you sure you want to delete this?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                <div x-show="editing" x-cloak style="display: none;">
                                    <form method="POST" action="{{ route('food-logs.update', $log) }}" class="space-y-3">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <x-text-input name="name" type="text" class="block w-full" required value="{{ $log->name }}" />
                                            </div>
                                            <div>
                                                <x-text-input name="calories" type="number" class="block w-full" required value="{{ $log->calories }}" min="0"/>
                                            </div>
                                            <div>
                                                <x-text-input name="consumed_at" type="date" class="block w-full" required value="{{ $log->consumed_at->format('Y-m-d') }}" />
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <x-primary-button>Update</x-primary-button>
                                            <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
