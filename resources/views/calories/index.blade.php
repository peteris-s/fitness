

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold">Calorie tracking</h1>
                        <a href="{{ route('calories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add calories
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 dark:bg-slate-700 p-4 rounded-lg">
                            <p class="text-gray-600 dark:text-gray-300">Today total</p>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">{{ $totalToday }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">calories</p>
                        </div>

                        <div class="bg-green-50 dark:bg-slate-700 p-4 rounded-lg">
                            <p class="text-gray-600 dark:text-gray-300">Daily target</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $dailyTarget ?? 'Not set' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-300">calories</p>
                        </div>

                        <div class="bg-white dark:bg-slate-700 p-4 rounded-lg shadow-sm dark:shadow-none">
                            <form id="target-form" method="POST" action="{{ route('calories.target') }}">
                                @csrf
                                @method('PATCH')
                                <label for="daily_calorie_target" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Set daily calorie target</label>
                                <div class="flex gap-2">
                                     <input type="number" name="daily_calorie_target" id="daily_calorie_target" min="0" max="100000"
                                         value="{{ old('daily_calorie_target', $dailyTarget) }}"
                                         class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500 bg-white dark:bg-slate-800 dark:border-gray-600 text-gray-900 dark:text-gray-100 form-control">
                                    <button id="target-save" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                                </div>
                                <p id="target-error" class="text-red-500 text-sm mt-2" style="display:none;"></p>
                                <p id="target-success" class="text-green-600 text-sm mt-2" style="display:none;"></p>
                            </form>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-200 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">Food item</th>
                                    <th class="px-4 py-2 text-left">Calories</th>
                                    <th class="px-4 py-2 text-left">Date</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2">
                                            <strong>{{ $log->food_name }}</strong>
                                            @if ($log->description)
                                                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $log->description }}</p>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $log->calories }}</td>
                                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $log->log_date->format('Y-m-d') }}</td>
                                        <td class="px-4 py-2">
                                            <a href="{{ route('calories.edit', $log) }}" class="text-blue-500 dark:text-blue-300 hover:text-blue-700 mr-2">Edit</a>
                                            <form action="{{ route('calories.destroy', $log) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">No calorie logs added</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('calories.stats') }}" class="text-blue-500 hover:text-blue-700">View statistics →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const form = document.getElementById('target-form');
        if (!form) return;
        const input = document.getElementById('daily_calorie_target');
        const display = document.querySelector('.bg-green-50 p.text-2xl');
        const errEl = document.getElementById('target-error');
        const successEl = document.getElementById('target-success');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            errEl.style.display = 'none';
            successEl.style.display = 'none';

            const url = form.getAttribute('action');
            const value = input.value;

            axios.post(url, {
                daily_calorie_target: value,
                _method: 'PATCH'
            }).then(function (res) {
                
                if (display) display.textContent = value || 'Not set';
                successEl.textContent = res.data.message || 'Daily calorie target saved!';
                successEl.style.display = 'block';
            }).catch(function (err) {
                if (err.response && err.response.data && err.response.data.errors && err.response.data.errors.daily_calorie_target) {
                    errEl.textContent = err.response.data.errors.daily_calorie_target[0];
                } else if (err.response && err.response.data && err.response.data.message) {
                    errEl.textContent = err.response.data.message;
                } else {
                    errEl.textContent = 'An error occurred. Please try again.';
                }
                errEl.style.display = 'block';
            });
        });
    })();
</script>
@endpush
