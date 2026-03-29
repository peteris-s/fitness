@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Workout Plans</h1>
        <a href="{{ route('workouts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create your plan</a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-200 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <section>
            <h2 class="text-xl font-semibold mb-4">My plans</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($myPlans as $plan)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-lg">{{ $plan->name }}</h3>
                            @if($plan->copied_from_id)
                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 px-2 py-1 rounded">Copy</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($plan->description, 120) }}</p>
                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('workouts.show', $plan) }}" class="text-blue-500">View</a>
                            <a href="{{ route('workouts.edit', $plan) }}" class="text-gray-600">Edit</a>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500">No plans yet. Create the first one!</div>
                @endforelse
            </div>
        </section>

        <section>
            <h2 class="text-xl font-semibold mb-4">Public plans from other users</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($publicPlans as $plan)
                    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold">{{ $plan->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($plan->description, 100) }}</p>
                                <p class="text-xs text-gray-500 mt-2">Author: {{ $plan->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <form method="POST" action="{{ route('plans.copy', $plan) }}">
                                    @csrf
                                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Copy</button>
                                </form>
                                <a href="{{ route('workouts.show', $plan) }}" class="block text-blue-500 mt-2">View</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500">No public plans right now.</div>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection
