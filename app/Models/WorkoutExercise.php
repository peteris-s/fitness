<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    use HasFactory;

    protected $table = 'workout_exercises';

    protected $fillable = [
        'workout_id',
        'exercise_id',
        'sets',
        'reps',
        'duration_seconds',
        'rest_seconds',
        'order',
    ];

    public function workout()
    {
        // Pieder pie `Workout`
        return $this->belongsTo(Workout::class);
    }

    public function exercise()
    {
        // Pieder pie `Exercise`
        return $this->belongsTo(Exercise::class);
    }
}
