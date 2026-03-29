<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'difficulty',
        'duration_minutes',
        'is_public',
        'copied_from_id',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'copied_from_id' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises')
            ->withPivot('sets', 'reps', 'duration_seconds', 'rest_seconds', 'order')
            ->orderBy('order')
            ->withTimestamps();
    }

    public function userWorkouts()
    {
        return $this->hasMany(UserWorkout::class);
    }

    public function completedBy()
    {
        return $this->belongsToMany(User::class, 'user_workouts')
            ->withPivot('completed_at', 'duration_minutes', 'notes')
            ->withTimestamps();
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
