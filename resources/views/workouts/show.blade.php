@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <div class="flex items-center gap-3">
                                <h1 class="text-3xl font-bold">{{ $workout->name }}</h1>
                                @if($workout->copied_from_id)
                                    <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded">Copy</span>
                                @endif
                            </div>
                            <p class="text-gray-600 mt-2">{{ $workout->user->name }}</p>
                        </div>
                        @if (auth()->user()->id === $workout->user_id)
                            <div class="flex gap-2" x-data="{ open: false }" @keydown.escape.window="open = false">
                                <a href="{{ route('workouts.edit', $workout) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                    Edit
                                </a>

                                <div>
                                    <form x-ref="deleteForm" action="{{ route('workouts.destroy', $workout) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" @click="open = true" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                            Delete
                                        </button>
                                    </form>

                                    <!-- Modal -->
                                    <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                                        <div class="fixed inset-0 bg-black bg-opacity-50" @click="open = false"></div>
                                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md mx-auto z-50 p-6" role="dialog" aria-modal="true">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Are you sure you want to delete this workout?</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">This action cannot be undone.</p>
                                            <div class="mt-4 flex justify-end gap-3">
                                                <button type="button" @click="open = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Cancel</button>
                                                <button type="button" @click="$refs.deleteForm.submit()" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            @if ($workout->is_public)
                                <div class="flex gap-2">
                                    <form action="{{ route('plans.copy', $workout) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Copy to my plans</button>
                                    </form>
                                </div>
                            @endif
                        @endif
                    </div>

                    @if ($workout->description)
                        <p class="text-gray-700 mb-6">{{ $workout->description }}</p>
                    @endif

                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg border border-blue-200 dark:border-blue-700">
                            <p class="text-blue-700 dark:text-blue-200 text-sm">Difficulty</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $workout->difficulty }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900 p-4 rounded-lg border border-green-200 dark:border-green-700">
                            <p class="text-green-700 dark:text-green-200 text-sm">Duration</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $workout->duration_minutes }} min</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg border border-purple-200 dark:border-purple-700">
                            <p class="text-purple-700 dark:text-purple-200 text-sm">Views</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $workout->views }}</p>
                        </div>
                        <div class="bg-amber-50 dark:bg-amber-900 p-4 rounded-lg border border-amber-200 dark:border-amber-700">
                            <p class="text-amber-700 dark:text-amber-200 text-sm">Completions</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $completions }}</p>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold mb-4">Exercises</h2>
                    <div class="space-y-4 mb-6">
                        @forelse ($exercises as $exercise)
                            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $exercise->name }}</h3>
                                    <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs px-3 py-1 rounded border border-gray-200 dark:border-gray-700">{{ $exercise->category }}</span>
                                </div>
                                @if ($exercise->description)
                                    <p class="text-gray-700 dark:text-gray-300 text-sm mb-3">{{ $exercise->description }}</p>
                                @endif
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400">Sets</p>
                                        <p class="font-bold text-gray-900 dark:text-gray-100">{{ $exercise->pivot->sets }}</p>
                                    </div>
                                    @if ($exercise->pivot->reps)
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-400">Reps</p>
                                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $exercise->pivot->reps }}</p>
                                        </div>
                                    @endif
                                    @if ($exercise->pivot->duration_seconds)
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-400">Duration</p>
                                            <p class="font-bold text-gray-900 dark:text-gray-100">{{ $exercise->pivot->duration_seconds }}s</p>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400">Rest</p>
                                        <p class="font-bold text-gray-900 dark:text-gray-100">{{ $exercise->pivot->rest_seconds }}s</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-700">There are no exercises at this time.</p>
                        @endforelse
                    </div>

                    @auth
                        @if (auth()->user()->id !== $workout->user_id)
                            <div class="flex gap-4">
                                <form action="{{ route('workouts.complete', $workout) }}" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label for="duration_minutes" class="block text-gray-700 font-bold mb-2">Actual duration (minutes)</label>
                                              <input type="number" name="duration_minutes" id="duration_minutes" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md form-control" min="1" max="480">
                                        </div>
                                        <div>
                                              <label for="notes" class="block text-gray-700 font-bold mb-2">Notes</label>
                                              <input type="text" name="notes" id="notes" 
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md form-control" placeholder="Add notes (optional)">
                                        </div>
                                    </div>
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        ✓ Complete workout
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth

                    <div class="mt-6">
                        <a href="{{ route('workouts.browse') }}" class="text-blue-500 hover:text-blue-700">← Back to workouts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
