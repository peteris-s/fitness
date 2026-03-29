<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercises = [
            ['name' => 'Push-Up', 'description' => 'A bodyweight exercise that primarily targets the chest, shoulders, and triceps.', 'category' => 'strength', 'difficulty' => 'beginner'],
            ['name' => 'Squat', 'description' => 'A lower body exercise that targets the quadriceps, hamstrings, glutes, and core.', 'category' => 'strength', 'difficulty' => 'intermediate'],
            ['name' => 'Plank', 'description' => 'An isometric core exercise that strengthens the abdominal muscles, back, and shoulders.', 'category' => 'core', 'difficulty' => 'beginner'],
            ['name' => 'Lunges', 'description' => 'A lower body exercise that targets the quadriceps, hamstrings, glutes, and calves.', 'category' => 'strength', 'difficulty' => 'intermediate'],
            ['name' => 'Burpees', 'description' => 'A full-body exercise that combines a squat, push-up, and jump to improve cardiovascular fitness and strength.', 'category' => 'cardio', 'difficulty' => 'advanced'],
        ];

        foreach ($exercises as $exercise) {
            \App\Models\Exercise::create($exercise);
        }
    }
}
