<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lets an authenticated user add a calorie log', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('calories.store'), [
            'food_name' => 'Banana',
            'calories' => 100,
            'description' => 'Medium banana',
            'log_date' => now()->toDateString(),
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('calorie_logs', ['food_name' => 'Banana']);
});
