@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-200">
                    <h1 class="text-3xl font-bold mb-6">Create new workout</h1>

                    <form method="POST" action="{{ route('workouts.store') }}" id="workoutForm">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Create workout name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-purple-300 dark:focus:ring-purple-500 form-control"
                                required>
                            @error('name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Apraksts</label>
                            <textarea name="description" id="description" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-purple-300 dark:focus:ring-purple-500 form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="difficulty" class="block text-gray-700 font-bold mb-2">Difficulty *</label>
                                <select name="difficulty" id="difficulty" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-purple-300 dark:focus:ring-purple-500 form-control" required>
                                    <option value="">Select</option>
                                    <option value="beginner" {{ old('difficulty') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('difficulty') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('difficulty') === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                                @error('difficulty')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="duration_minutes" class="block text-gray-700 font-bold mb-2">Duration (minutes) *</label>
                                        <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', 30) }}" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-purple-500 placeholder-gray-400 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 bg-white dark:bg-slate-700 dark:border-gray-600 focus:ring-2 focus:ring-purple-300 dark:focus:ring-purple-500 form-control"
                                       min="5" max="480" required>
                                @error('duration_minutes')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_public" value="1" {{ old('is_public') ? 'checked' : '' }} class="mr-2">
                                <span class="text-gray-700">Public workout (visible to other users)</span>
                            </label>
                        </div>

                        <div class="mb-6">
                            <h2 class="text-2xl font-bold mb-4">Exercises</h2>
                            <div id="exercisesContainer">

                                <div class="exercise-item mb-4 p-4 rounded-lg bg-white dark:bg-slate-800 border border-gray-200 dark:border-gray-700">
                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <label class="block text-gray-700 font-bold mb-2">Exercise *</label>
                                            <div class="relative">
                                                <input type="text" name="exercises[0][exercise_name]" class="w-full px-3 py-2 rounded-md bg-white dark:bg-slate-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 suggestion-input form-control" required autocomplete="off">
                                                <ul class="suggestions hidden absolute left-0 right-0 mt-1 bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded z-10 max-h-48 overflow-auto text-sm"></ul>
                                            </div>
                                            <input type="hidden" name="exercises[0][exercise_id]" value="">
                                        </div>

                                        <div>
                                            <label class="block text-gray-700 font-bold mb-2">Sets *</label>
                                            <input type="number" name="exercises[0][sets]" value="3" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 form-control" min="1" max="10" required>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-3 gap-4 mb-4">
                                        <div>
                                            <label class="block text-gray-700 font-bold mb-2">Reps</label>
                                            <input type="number" name="exercises[0][reps]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 form-control" min="1" max="100">
                                        </div>

                                        <div>
                                            <label class="block text-gray-700 font-bold mb-2">Duration (seconds)</label>
                                            <input type="number" name="exercises[0][duration_seconds]" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 form-control" min="10" max="3600">
                                        </div>

                                        <div>
                                            <label class="block text-gray-700 font-bold mb-2">Rest (seconds) *</label>
                                            <input type="number" name="exercises[0][rest_seconds]" value="60" class="w-full px-3 py-2 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 form-control" min="0" max="600" required>
                                        </div>
                                    </div>

                                    <button type="button" class="bg-red-600 hover:bg-red-800 text-white font-bold py-1 px-3 rounded remove-exercise" style="display: none;">
                                        Remove exercise
                                    </button>
                                </div>
                            </div>

                            <button type="button" id="addExerciseBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Add exercise
                            </button>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Create workout
                            </button>
                            <a href="{{ route('workouts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const exercisesData = @json($exercises->map(fn($e) => ['id' => $e->id, 'name' => $e->name]));

function mapNameToId(inputEl) {
    const name = inputEl.value.trim();
    const item = inputEl.closest('.exercise-item');
    const hidden = item.querySelector('input[type="hidden"][name*="[exercise_id]"]');
    const found = exercisesData.find(e => e.name.toLowerCase() === name.toLowerCase());
    hidden.value = found ? found.id : '';
}

function attachMapping(el) {
    const nameInput = el.querySelector('.suggestion-input');
    if (!nameInput) return;
    nameInput.addEventListener('change', () => mapNameToId(nameInput));
    nameInput.addEventListener('input', () => mapNameToId(nameInput));
    attachSuggestions(el);
}

function attachSuggestions(el) {
    const input = el.querySelector('.suggestion-input');
    const box = el.querySelector('.suggestions');
    if (!input || !box) return;

    function render(filter) {
        const names = [...new Set(exercisesData.map(e => e.name))];
        let results = names;
        if (filter) {
            const q = filter.toLowerCase();
            results = names.filter(n => n.toLowerCase().includes(q));
        }
        results = results.slice(0, 8);
        if (results.length === 0) {
            box.classList.add('hidden');
            box.innerHTML = '';
            return;
        }
        box.innerHTML = results.map(r => `<li class="px-3 py-2 hover:bg-gray-100 dark:hover:bg-slate-600 cursor-pointer">${r}</li>`).join('');
        box.classList.remove('hidden');

        box.querySelectorAll('li').forEach(li => {
            li.addEventListener('mousedown', function (e) {
                e.preventDefault();
                input.value = this.textContent;
                mapNameToId(input);
                box.classList.add('hidden');
            });
        });
    }

    input.addEventListener('input', function () { render(this.value); });
    input.addEventListener('focus', function () { render(''); });
    input.addEventListener('blur', function () { setTimeout(() => box.classList.add('hidden'), 150); });
}

document.querySelectorAll('.exercise-item').forEach(item => attachMapping(item));

document.getElementById('addExerciseBtn').addEventListener('click', function() {
    const container = document.getElementById('exercisesContainer');
    const index = container.querySelectorAll('.exercise-item').length;
    const template = container.querySelector('.exercise-item');
    const newExercise = template.cloneNode(true);

    newExercise.querySelectorAll('input').forEach(el => {
        if (el.name) {
            el.name = el.name.replace(/\[\d+\]/, '[' + index + ']');
        }
        if (el.type === 'number') {
            if (el.name && el.name.includes('sets')) el.value = 3;
            else if (el.name && el.name.includes('rest')) el.value = 60;
            else el.value = '';
        } else if (el.type === 'hidden') {
            el.value = '';
        } else if (el.type === 'text') {
            el.value = '';
        }
    });

    const removeBtn = newExercise.querySelector('.remove-exercise');
    removeBtn.style.display = 'inline-block';
    removeBtn.addEventListener('click', function() { newExercise.remove(); });

    attachMapping(newExercise);
    container.appendChild(newExercise);

    // show remove buttons when >1
    if (container.querySelectorAll('.exercise-item').length > 1) {
        container.querySelectorAll('.exercise-item').forEach(it => it.querySelector('.remove-exercise').style.display = 'inline-block');
    }
});

// Show remove button for first item if there are multiple
document.querySelectorAll('.exercise-item').forEach((item, index) => {
    if (document.querySelectorAll('.exercise-item').length > 1) {
        item.querySelector('.remove-exercise').style.display = 'inline-block';
    }
});
</script>
@endsection
