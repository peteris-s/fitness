<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Workout;
use App\Models\Exercise;
use App\Models\User;

class DemoWorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have a user to attach workouts to
        $user = User::first();
        if (! $user) {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Define some reusable exercises (will be created if missing)
        $exercises = [
            ['name' => 'Push-ups', 'description' => 'Standard push-up', 'category' => 'strength', 'difficulty' => 'beginner'],
            ['name' => 'Squats', 'description' => 'Bodyweight squats', 'category' => 'strength', 'difficulty' => 'beginner'],
            ['name' => 'Plank', 'description' => 'Core plank hold', 'category' => 'core', 'difficulty' => 'beginner'],
            ['name' => 'Burpees', 'description' => 'Full body conditioning', 'category' => 'cardio', 'difficulty' => 'intermediate'],
            ['name' => 'Lunges', 'description' => 'Forward lunges', 'category' => 'strength', 'difficulty' => 'beginner'],
            ['name' => 'Mountain Climbers', 'description' => 'Core + cardio', 'category' => 'cardio', 'difficulty' => 'intermediate'],
            ['name' => 'Jumping Jacks', 'description' => 'Warm up exercise', 'category' => 'cardio', 'difficulty' => 'beginner'],
            ['name' => 'Bicycle Crunches', 'description' => 'Abdominal exercise', 'category' => 'core', 'difficulty' => 'intermediate'],
        ];

        $exerciseMap = [];
        foreach ($exercises as $ex) {
            $model = Exercise::firstOrCreate([
                'name' => $ex['name']
            ], $ex);
            $exerciseMap[$model->name] = $model;
        }

        // Workouts to create
        $workouts = [
            [
                'name' => 'Full Body Starter',
                'description' => 'A beginner-friendly full body circuit to get started.',
                'difficulty' => 'beginner',
                'duration_minutes' => 25,
                'is_public' => true,
                'exercises' => [
                    ['name' => 'Jumping Jacks', 'sets' => 3, 'reps' => 30, 'duration_seconds' => null, 'rest_seconds' => 30],
                    ['name' => 'Squats', 'sets' => 3, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 45],
                    ['name' => 'Push-ups', 'sets' => 3, 'reps' => 8, 'duration_seconds' => null, 'rest_seconds' => 45],
                    ['name' => 'Plank', 'sets' => 3, 'reps' => null, 'duration_seconds' => 45, 'rest_seconds' => 30],
                ],
            ],
            [
                'name' => 'Cardio Blast',
                'description' => 'High-intensity interval workout to raise your heart rate.',
                'difficulty' => 'intermediate',
                'duration_minutes' => 20,
                'is_public' => true,
                'exercises' => [
                    ['name' => 'Burpees', 'sets' => 4, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 30],
                    ['name' => 'Mountain Climbers', 'sets' => 4, 'reps' => 30, 'duration_seconds' => null, 'rest_seconds' => 30],
                    ['name' => 'Jumping Jacks', 'sets' => 3, 'reps' => 40, 'duration_seconds' => null, 'rest_seconds' => 30],
                ],
            ],
            [
                'name' => 'Core Focus',
                'description' => 'Targeted abs and core routine for stability and strength.',
                'difficulty' => 'intermediate',
                'duration_minutes' => 18,
                'is_public' => true,
                'exercises' => [
                    ['name' => 'Plank', 'sets' => 4, 'reps' => null, 'duration_seconds' => 60, 'rest_seconds' => 30],
                    ['name' => 'Bicycle Crunches', 'sets' => 4, 'reps' => 20, 'duration_seconds' => null, 'rest_seconds' => 30],
                    ['name' => 'Mountain Climbers', 'sets' => 3, 'reps' => 30, 'duration_seconds' => null, 'rest_seconds' => 30],
                ],
            ],
            [
                'name' => 'Lower Body Strength',
                'description' => 'Build leg strength with focused lower-body movements.',
                'difficulty' => 'advanced',
                'duration_minutes' => 30,
                'is_public' => true,
                'exercises' => [
                    ['name' => 'Squats', 'sets' => 4, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60],
                    ['name' => 'Lunges', 'sets' => 4, 'reps' => 12, 'duration_seconds' => null, 'rest_seconds' => 60],
                    ['name' => 'Jumping Jacks', 'sets' => 3, 'reps' => 50, 'duration_seconds' => null, 'rest_seconds' => 45],
                ],
            ],
            [
                'name' => 'Quick Office Circuit',
                'description' => 'Short circuit you can do at home or at the office.',
                'difficulty' => 'beginner',
                'duration_minutes' => 12,
                'is_public' => false,
                'exercises' => [
                    ['name' => 'Push-ups', 'sets' => 3, 'reps' => 10, 'duration_seconds' => null, 'rest_seconds' => 30],
                    ['name' => 'Squats', 'sets' => 3, 'reps' => 15, 'duration_seconds' => null, 'rest_seconds' => 30],
                    ['name' => 'Plank', 'sets' => 2, 'reps' => null, 'duration_seconds' => 45, 'rest_seconds' => 30],
                ],
            ],
        ];

        foreach ($workouts as $w) {
            $workout = Workout::create([
                'user_id' => $user->id,
                'name' => $w['name'],
                'description' => $w['description'],
                'difficulty' => $w['difficulty'],
                'duration_minutes' => $w['duration_minutes'],
                'is_public' => $w['is_public'],
            ]);

            // Attach exercises in order
            $order = 1;
            foreach ($w['exercises'] as $ex) {
                $exModel = Exercise::firstOrCreate(['name' => $ex['name']], ['description' => $ex['name']]);
                $workout->exercises()->attach($exModel->id, [
                    'sets' => $ex['sets'],
                    'reps' => $ex['reps'],
                    'duration_seconds' => $ex['duration_seconds'],
                    'rest_seconds' => $ex['rest_seconds'],
                    'order' => $order,
                ]);
                $order++;
            }
        }
    }
}
