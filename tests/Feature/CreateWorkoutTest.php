<?php

use App\Models\User;
use App\Models\Exercise;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows an authenticated user to create a workout with exercises', function () {
    $user = User::factory()->create();

    // create an exercise
    $exercise = Exercise::create(['name' => 'Test Exercise', 'category' => 'general', 'difficulty' => 'beginner']);

    $this->actingAs($user)
        ->post(route('workouts.store'), [
            'name' => 'Test Plan',
            'description' => 'Test description',
            'difficulty' => 'beginner',
            'duration_minutes' => 20,
            'is_public' => true,
            'exercises' => [
                [
                    'exercise_id' => $exercise->id,
                    'exercise_name' => $exercise->name,
                    'sets' => 3,
                    'reps' => 12,
                    'duration_seconds' => null,
                    'rest_seconds' => 60,
                ],
            ],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('workouts', ['name' => 'Test Plan']);
});
