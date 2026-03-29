<?php

namespace App\Policies;

use App\Models\CalorieLog;
use App\Models\User;

class CalorieLogPolicy
{
    public function update(User $user, CalorieLog $calorieLog): bool
    {
        return $user->id === $calorieLog->user_id;
    }

    public function delete(User $user, CalorieLog $calorieLog): bool
    {
        return $user->id === $calorieLog->user_id;
    }
}
