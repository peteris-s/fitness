<x-app-layout>
    {{--
        Dashboard izmanto šādus mainīgos:
        $totalToday, $dailyTarget, $recentLogs,
        $recentWorkoutName, $recentWorkoutDate, $featured
    --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Quick actions -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                            <div class="flex flex-col gap-3">
                            <a href="{{ route('calories.create') }}" class="w-full text-center bg-purple-600 hover:bg-purple-700 text-white py-2 px-3 rounded">Add calories</a>
                            <a href="{{ route('workouts.create') }}" class="w-full text-center bg-purple-500 hover:bg-purple-600 text-white py-2 px-3 rounded">Create workout</a>
                            <a href="{{ route('workouts.browse') }}" class="w-full text-center bg-purple-400 hover:bg-purple-500 text-white py-2 px-3 rounded">Browse plans</a>
                        </div>
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">Tips</h4>
                            <ul class="mt-2 text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <li>Log calories daily to track progress.</li>
                                <li>Create a workout and mark it complete.</li>
                                <li>Browse public plans for ideas.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Snapshot cards -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex flex-col md:flex-row md:items-stretch md:gap-4">
                            <div class="flex-1 bg-purple-50 dark:bg-slate-700 p-4 rounded-lg">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Today total</p>
                                <p class="text-3xl font-bold text-purple-700 dark:text-purple-300">{{ isset($totalToday) ? $totalToday : '—' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">calories</p>
                            </div>

                            <div class="flex-1 bg-purple-50 dark:bg-slate-700 p-4 rounded-lg mt-4 md:mt-0">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Daily target</p>
                                <p class="text-3xl font-bold text-purple-600 dark:text-purple-300">{{ isset($dailyTarget) ? $dailyTarget : 'Not set' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">calories</p>
                            </div>

                            <div class="flex-1 bg-white dark:bg-slate-700 p-4 rounded-lg mt-4 md:mt-0">
                                <p class="text-sm text-gray-600 dark:text-gray-300">Recent workout</p>
                                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ isset($recentWorkoutName) ? $recentWorkoutName : 'No recent workout' }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ isset($recentWorkoutDate) ? $recentWorkoutDate : '' }}</p>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-semibold mb-3">Recent activity</h3>
                            <div class="space-y-3">
                                @if(isset($recentLogs) && count($recentLogs))
                                    @foreach($recentLogs as $log)
                                        <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-900 p-3 rounded">
                                            <div>
                                                <div class="text-sm font-medium">{{ $log->food_name }}</div>
                                                @if($log->description)
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $log->description }}</div>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-700 dark:text-gray-200">{{ $log->calories }} kcal</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-sm text-gray-500">No recent activity</div>
                                @endif
                            </div>
                        </div>
                        @if(isset($featured) && count($featured))
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold mb-3">Featured public workouts</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($featured as $f)
                                        <a href="{{ route('workouts.show', $f->id) }}" class="block bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-lg p-4 hover:shadow">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $f->user->name ?? '—' }}</div>
                                                    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $f->name }}</div>
                                                </div>
                                                <div class="text-sm text-gray-600 dark:text-gray-300">{{ $f->exercises()->count() }} ex</div>
                                            </div>
                                            @if($f->description)
                                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($f->description, 120) }}</p>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
