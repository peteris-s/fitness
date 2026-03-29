<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'difficulty',
    ];

    public function workouts()
    {
        return $this->belongsToMany(Workout::class, 'workout_exercises')
            ->withPivot('sets', 'reps', 'duration_seconds', 'rest_seconds', 'order')
            ->withTimestamps();
    }
}
