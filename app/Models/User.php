<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'avatar',
        'daily_calorie_target',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'daily_calorie_target' => 'integer',
    ];

    public function calorieLogs()
    {
        // Attiecība: lietotājam ir daudz kaloriju ierakstu
        return $this->hasMany(CalorieLog::class);
    }

    public function workouts()
    {
        // Lietotāja izveidotie treniņi
        return $this->hasMany(Workout::class);
    }

    public function completedWorkouts()
    {
        // Pivot attiecība uz pabeigtajiem treniņiem ar papildu informāciju
        return $this->belongsToMany(Workout::class, 'user_workouts')
            ->withPivot('completed_at', 'duration_minutes', 'notes')
            ->withTimestamps();
    }

    public function userWorkouts()
    {
        // Tiešā attiecība uz `UserWorkout` ierakstiem
        return $this->hasMany(UserWorkout::class);
    }
}
