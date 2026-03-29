@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h1 class="text-3xl font-bold mb-6">Add calorie entry</h1>

                    <form method="POST" action="{{ route('calories.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="food_name" class="block text-gray-700 font-bold mb-2">Food item *</label>
                            <input type="text" name="food_name" id="food_name" value="{{ old('food_name') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-500 form-control"
                                required>
                            @error('food_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="calories" class="block text-gray-700 font-bold mb-2">Calories (kcal) *</label>
                            <input type="number" name="calories" id="calories" value="{{ old('calories') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-500 form-control"
                                   min="1" max="10000" required>
                            @error('calories')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-500 form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="log_date" class="block text-gray-700 font-bold mb-2">Date *</label>
                            <input type="date" name="log_date" id="log_date" value="{{ old('log_date', now()->format('Y-m-d')) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 form-control"
                                   required>
                            @error('log_date')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add
                            </button>
                            <a href="{{ route('calories.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
