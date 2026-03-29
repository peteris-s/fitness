<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workout;

class WorkoutPolicy
{
    public function view(?User $user, Workout $workout)
    {
        if ($workout->is_public) return true;
        return $user && $user->id === $workout->user_id;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Workout $workout)
    {
        return $user->id === $workout->user_id;
    }

    public function delete(User $user, Workout $workout)
    {
        return $user->id === $workout->user_id;
    }
}

