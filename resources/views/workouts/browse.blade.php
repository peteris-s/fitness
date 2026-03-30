@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold">Browse workouts</h1>
                    </div>

                    <form method="GET" action="{{ route('workouts.search') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <input type="text" name="q" placeholder="Search workouts..." value="{{ request('q') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 form-control">
                            </div>
                            <div>
                                <select name="difficulty" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 form-control">
                                    <option value="">All difficulties</option>
                                    <option value="beginner" {{ request('difficulty') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ request('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ request('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Search
                            </button>
                        </div>
                    </form>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- $workouts: publikie treniņi, nodrošina kopēšanu un skatīšanos --}}
                        @forelse ($workouts as $workout)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-lg transition bg-white dark:bg-gray-800">
                                <div class="flex justify-between items-start mb-2">
                                    <h2 class="text-xl font-bold">{{ $workout->name }}</h2>
                                    @php
                                        // Aprēķina krāsu difficulty badge (beginner/intermediate/advanced)
                                        $d = $workout->difficulty;
                                        $color = $d === 'beginner' ? 'green' : ($d === 'intermediate' ? 'yellow' : 'red');
                                    @endphp
                                    <span class="text-xs px-3 py-1 rounded bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-800 dark:bg-opacity-30 dark:text-{{ $color }}-200">
                                        {{ $workout->difficulty }}
                                    </span>
                                </div>

                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">👤 {{ $workout->user->name }}</p>

                                @if ($workout->description)
                                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-2">{{ Str::limit($workout->description, 100) }}</p>
                                @endif

                                <div class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                                    <p>⏱️ {{ $workout->duration_minutes }} minutes</p>
                                    <p>👁️ {{ $workout->views }} times viewed</p>
                                </div>

                                <div class="space-y-2">
                                    <a href="{{ route('workouts.show', $workout) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full text-center block">
                                        View details
                                    </a>
                                    @auth
                                        @if($workout->is_public && auth()->id() !== $workout->user_id)
                                            <form method="POST" action="{{ route('plans.copy', $workout) }}">
                                                @csrf
                                                <button class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">Copy</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-500 dark:text-gray-400 py-8">
                                No workouts found. Try different search parameters.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $workouts->links() }}
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('workouts.index') }}" class="text-blue-500 dark:text-blue-300 hover:text-blue-700">← Back to my workouts</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
