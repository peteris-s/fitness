<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use App\Models\WorkoutExercise;
use App\Models\UserWorkout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkoutController extends Controller
{
    // Kontrolieris pārvalda treniņu CRUD, publisko pārlūkošanu un kopēšanu.
    public function index()
    {
        // Rāda lietotāja izveidotos treniņus lapotnē `workouts.index`.
        $workouts = auth()->user()->workouts()->orderByDesc('created_at')->paginate(12);
        return view('workouts.index', compact('workouts'));
    }

    public function create()
    {
        // Rāda formu jauna treniņa izveidei; nodrošina pieejamos vingrinājumus.
        $exercises = Exercise::orderBy('name')->get();
        return view('workouts.create', compact('exercises'));
    }

    public function store(Request $request)
    {
        // Validē un saglabā jaunu treniņu un tā vingrinājumus
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'is_public' => 'nullable|boolean',
            'exercises' => 'array',
            'exercises.*.exercise_id' => 'nullable|exists:exercises,id',
            'exercises.*.exercise_name' => 'nullable|string|max:255',
            'exercises.*.sets' => 'required|integer|min:1|max:10',
            'exercises.*.reps' => 'nullable|integer|min:1|max:100',
            'exercises.*.duration_seconds' => 'nullable|integer|min:10|max:3600',
            'exercises.*.rest_seconds' => 'required|integer|min:0|max:600',
        ];

        $data = $request->validate($rules);
        $data['user_id'] = auth()->id();
        $data['is_public'] = $request->has('is_public');

        $w = Workout::create($data);

        if (!empty($data['exercises'])) {
            foreach ($data['exercises'] as $i => $e) {
                if (empty($e['exercise_id']) && !empty($e['exercise_name'])) {
                    $exercise = Exercise::where('name', $e['exercise_name'])->first();
                    if (! $exercise) {
                        $exercise = Exercise::create([
                            'name' => $e['exercise_name'],
                            'category' => 'general',
                            'difficulty' => 'beginner',
                        ]);
                    }
                    $data['exercises'][$i]['exercise_id'] = $exercise->id;
                }

                if (empty($data['exercises'][$i]['exercise_id'])) {
                    continue;
                }

                $eId = $data['exercises'][$i]['exercise_id'];

                WorkoutExercise::create([
                    'workout_id' => $w->id,
                    'exercise_id' => $eId,
                    'sets' => $e['sets'],
                    'reps' => $e['reps'] ?? null,
                    'duration_seconds' => $e['duration_seconds'] ?? null,
                    'rest_seconds' => $e['rest_seconds'],
                    'order' => $i + 1,
                ]);
            }
        }

        // Pāradresē uz jauna treniņa skatu ar veiksmīgas saglabāšanas paziņojumu
        return redirect()->route('workouts.show', $w)->with('success', 'Workout created!');
    }

    public function show(Workout $workout)
    {
        // Palielina skatu skaitu un uzstāda vajadzīgos mainīgos treniņa skata renderēšanai
        $workout->incrementViews();
        $exercises = $workout->exercises()->withPivot('sets', 'reps', 'duration_seconds', 'rest_seconds')->get();
        $completions = $workout->userWorkouts()->count();
        return view('workouts.show', compact('workout', 'exercises', 'completions'));
    }

    public function edit(Workout $workout)
    {
        // Rāda rediģēšanas formu (autorizācija nepieciešama)
        $this->authorize('update', $workout);
        $exercises = Exercise::orderBy('name')->get();
        $workoutExercises = $workout->exercises()->withPivot('sets', 'reps', 'duration_seconds', 'rest_seconds')->get();
        return view('workouts.edit', compact('workout', 'exercises', 'workoutExercises'));
    }

    public function update(Request $request, Workout $workout)
    {
        // Atjaunina treniņa datus un pārraksta saistītos vingrinājumus
        $this->authorize('update', $workout);
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'duration_minutes' => 'required|integer|min:5|max:480',
            'is_public' => 'nullable|boolean',
            'exercises' => 'array',
            'exercises.*.exercise_id' => 'nullable|exists:exercises,id',
            'exercises.*.exercise_name' => 'nullable|string|max:255',
            'exercises.*.sets' => 'required|integer|min:1|max:10',
            'exercises.*.reps' => 'nullable|integer|min:1|max:100',
            'exercises.*.duration_seconds' => 'nullable|integer|min:10|max:3600',
            'exercises.*.rest_seconds' => 'required|integer|min:0|max:600',
        ];

        $data = $request->validate($rules);
        $data['is_public'] = $request->has('is_public');
        $workout->update($data);

        WorkoutExercise::where('workout_id', $workout->id)->delete();
        if (!empty($data['exercises'])) {
            foreach ($data['exercises'] as $i => $e) {
                if (empty($e['exercise_id']) && !empty($e['exercise_name'])) {
                    $exercise = Exercise::where('name', $e['exercise_name'])->first();
                    if (! $exercise) {
                        $exercise = Exercise::create([
                            'name' => $e['exercise_name'],
                            'category' => 'general',
                            'difficulty' => 'beginner',
                        ]);
                    }
                    $data['exercises'][$i]['exercise_id'] = $exercise->id;
                }

                if (empty($data['exercises'][$i]['exercise_id'])) {
                    continue;
                }

                $eId = $data['exercises'][$i]['exercise_id'];

                WorkoutExercise::create([
                    'workout_id' => $workout->id,
                    'exercise_id' => $eId,
                    'sets' => $e['sets'],
                    'reps' => $e['reps'] ?? null,
                    'duration_seconds' => $e['duration_seconds'] ?? null,
                    'rest_seconds' => $e['rest_seconds'],
                    'order' => $i + 1,
                ]);
            }
        }

        return redirect()->route('workouts.show', $workout)->with('success', 'Workout updated!');
    }

    public function destroy(Workout $workout)
    {
        // Dzēš treniņu (autorizācija)
        $this->authorize('delete', $workout);
        $workout->delete();
        return redirect()->route('workouts.index')->with('success', 'Workout deleted!');
    }

    public function complete(Workout $workout, Request $request)
    {
        // Atzīmē treniņu kā pabeigtu un saglabā pabeigšanas informāciju
        $v = $request->validate(['duration_minutes' => 'nullable|integer|min:1|max:480', 'notes' => 'nullable|string|max:1000']);
        auth()->user()->userWorkouts()->create(['workout_id' => $workout->id, 'completed_at' => now(), 'duration_minutes' => $v['duration_minutes'] ?? null, 'notes' => $v['notes'] ?? null]);
        return redirect()->route('workouts.show', $workout)->with('success', 'Workout marked as completed!');
    }

    public function browse()
    {
        $workouts = Workout::where('is_public', true)->with('user')->orderBy('views', 'desc')->paginate(12);
        return view('workouts.browse', compact('workouts'));
    }

    public function search(Request $request)
    {
        $search = $request->query('q');
        $difficulty = $request->query('difficulty');
        $workouts = Workout::where('is_public', true)
            ->when($search, fn($q) => $q->where('name', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"))
            ->when($difficulty, fn($q) => $q->where('difficulty', $difficulty))
            ->with('user')->orderBy('views', 'desc')->paginate(12);
        return view('workouts.browse', compact('workouts', 'search', 'difficulty'));
    }

    public function plans()
    {
        $user = auth()->user();
        $myPlans = $user->workouts()->orderByDesc('created_at')->get();
        $publicPlans = Workout::where('is_public', true)->where('user_id', '!=', $user->id)->orderByDesc('created_at')->limit(24)->get();
        return view('treninu_plani.index', compact('myPlans', 'publicPlans'));
    }

    public function copy(Request $request, Workout $workout)
    {
        // only allow copying public plans (or user's own)
        if (! $workout->is_public && $workout->user_id !== auth()->id()) {
            abort(403);
        }

        DB::transaction(function () use ($workout) {
            $new = Workout::create([
                'user_id' => auth()->id(),
                'name' => $workout->name . ' (kopija)',
                'description' => $workout->description,
                'difficulty' => $workout->difficulty,
                'duration_minutes' => $workout->duration_minutes,
                'is_public' => false,
                'views' => 0,
                'copied_from_id' => $workout->id,
            ]);

            // copy exercises
            foreach ($workout->workoutExercises()->orderBy('order')->get() as $we) {
                WorkoutExercise::create([
                    'workout_id' => $new->id,
                    'exercise_id' => $we->exercise_id,
                    'sets' => $we->sets,
                    'reps' => $we->reps,
                    'duration_seconds' => $we->duration_seconds,
                    'rest_seconds' => $we->rest_seconds,
                    'order' => $we->order,
                ]);
            }
        });

        return redirect()->route('plans.index')->with('success', 'Workout copied to your plans.');
    }
}
