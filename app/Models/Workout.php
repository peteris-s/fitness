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
        // Treniņa autors (lietotājs)
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        // Daudz-uz-daudz attiecība uz vingrinājumiem ar papildus lauciņiem pivot tabulā
        return $this->belongsToMany(Exercise::class, 'workout_exercises')
            ->withPivot('sets', 'reps', 'duration_seconds', 'rest_seconds', 'order')
            ->orderBy('order')
            ->withTimestamps();
    }

    public function workoutExercises()
    {
        // Tiešā attiecība uz `WorkoutExercise` ierakstiem, izmanto kopēšanai un kārtas saglabāšanai
        return $this->hasMany(WorkoutExercise::class)->orderBy('order');
    }

    public function userWorkouts()
    {
        // Attiecība uz `UserWorkout` — lietotāju pabeigtie treniņi
        return $this->hasMany(UserWorkout::class);
    }

    public function completedBy()
    {
        // Pivot attiecība: kuri lietotāji ir pabeiguši šo treniņu
        return $this->belongsToMany(User::class, 'user_workouts')
            ->withPivot('completed_at', 'duration_minutes', 'notes')
            ->withTimestamps();
    }

    public function incrementViews()
    {
        // Palielina skatījumu skaitu
        $this->increment('views');
    }
}
