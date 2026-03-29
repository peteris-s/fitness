<?php

namespace Database\Seeders;

use App\Models\CalorieLog;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CalorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        if (! $user) return;

        CalorieLog::create([
            'user_id' => $user->id,
            'food_name' => 'Chicken breast',
            'calories' => 220,
            'description' => 'Grilled, 150g',
            'log_date' => now()->toDateString(),
        ]);

        CalorieLog::create([
            'user_id' => $user->id,
            'food_name' => 'Oatmeal',
            'calories' => 150,
            'description' => 'With milk',
            'log_date' => now()->toDateString(),
        ]);
    }
}
