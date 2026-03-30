@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold">My Workouts</h1>
                            <a href="{{ route('workouts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create new workout
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- $workouts: lietotāja izveidotie treniņi --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($workouts as $workout)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                                <div class="flex justify-between items-start mb-2">
                                    <h2 class="text-xl font-bold">{{ $workout->name }}</h2>
                                    <span class="bg-{{ $workout->difficulty === 'beginner' ? 'green' : ($workout->difficulty === 'intermediate' ? 'yellow' : 'red') }}-100 text-{{ $workout->difficulty === 'beginner' ? 'green' : ($workout->difficulty === 'intermediate' ? 'yellow' : 'red') }}-800 text-xs px-3 py-1 rounded">
                                        {{ $workout->difficulty }}
                                    </span>
                                </div>

                                @if ($workout->description)
                                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($workout->description, 100) }}</p>
                                @endif

                                <div class="text-sm text-gray-600 mb-4">
                                    <p>⏱️ {{ $workout->duration_minutes }} minutes</p>
                                    <p>👁️ {{ $workout->views }} times viewed</p>
                                </div>

                                <div class="flex gap-2">
                                        <a href="{{ route('workouts.show', $workout) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        View
                                    </a>
                                    <a href="{{ route('workouts.edit', $workout) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('workouts.destroy', $workout) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-gray-500 py-8">
                                No workouts created. <a href="{{ route('workouts.create') }}" class="text-blue-500 hover:text-blue-700">Create the first workout.</a>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $workouts->links() }}
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('workouts.browse') }}" class="text-blue-500 hover:text-blue-700">Browse other workouts →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
