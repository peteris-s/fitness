@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h1 class="text-3xl font-bold mb-6">Edit calorie entry</h1>

                    <form method="POST" action="{{ route('calories.update', $calorieLog) }}">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label for="food_name" class="block text-gray-700 font-bold mb-2">Food item *</label>
                            <input type="text" name="food_name" id="food_name" value="{{ $calorieLog->food_name }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 form-control"
                                required>
                            @error('food_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="calories" class="block text-gray-700 font-bold mb-2">Calories (kcal) *</label>
                            <input type="number" name="calories" id="calories" value="{{ $calorieLog->calories }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 form-control"
                                min="1" max="10000" required>
                                   min="1" max="10000" required>
                            @error('calories')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 form-control">{{ $calorieLog->description }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="log_date" class="block text-gray-700 font-bold mb-2">Date *</label>
                            <input type="date" name="log_date" id="log_date" value="{{ $calorieLog->log_date->format('Y-m-d') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 form-control"
                                   required>
                            @error('log_date')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Update
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
