@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h1 class="text-3xl font-bold mb-6">Calorie statistics</h1>

                    {{-- $statsToday — šodienas summa; $stats7Days — pēdējo 7 dienu kopsavilkums; $stats30Days — pēdējo 30 dienu dati. --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 dark:bg-slate-700 p-4 rounded-lg">
                            <p class="text-gray-600 dark:text-gray-300">Today total</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">{{ $statsToday }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">calories</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-700 p-4 rounded-lg mb-6">
                        <h2 class="text-xl font-bold mb-4">Last 7 days</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Calories</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stats7Days as $stat)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $stat->log_date }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $stat->total }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">No data for the last 7 days</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-700 p-4 rounded-lg">
                        <h2 class="text-xl font-bold mb-4">Last 30 days</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-200 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Calories</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($stats30Days as $stat)
                                        <tr class="border-b dark:border-gray-700">
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $stat->log_date }}</td>
                                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">{{ $stat->total }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">No data for the last 30 days</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('calories.index') }}" class="text-blue-500 hover:text-blue-700">← Back to calorie tracking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
