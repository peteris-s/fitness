<?php

namespace Database\Seeders;

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\WorkoutExercise;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (! $user) return;

        $exercises = Exercise::all();
        if ($exercises->isEmpty()) {
            $exercises = collect([
                Exercise::create(['name' => 'Push-Up', 'description' => 'Bodyweight chest/arms', 'category' => 'strength', 'difficulty' => 'beginner']),
                Exercise::create(['name' => 'Squat', 'description' => 'Lower body', 'category' => 'strength', 'difficulty' => 'intermediate']),
                Exercise::create(['name' => 'Plank', 'description' => 'Core isometric', 'category' => 'core', 'difficulty' => 'beginner']),
            ]);
        }

        $w = Workout::create([
            'user_id' => $user->id,
            'name' => 'Full Body Starter',
            'description' => 'A simple full-body routine for beginners.',
            'difficulty' => 'beginner',
            'duration_minutes' => 25,
            'is_public' => true,
            'views' => 12,
        ]);

        $i = 1;
        foreach ($exercises->take(3) as $ex) {
            WorkoutExercise::create([
                'workout_id' => $w->id,
                'exercise_id' => $ex->id,
                'sets' => 3,
                'reps' => 10,
                'duration_seconds' => null,
                'rest_seconds' => 60,
                'order' => $i,
            ]);
            $i++;
        }
    }
}
