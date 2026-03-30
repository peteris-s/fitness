<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWorkout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_id',
        'completed_at',
        'duration_minutes',
        'notes',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        // Saite uz lietotāju, kurš pabeidza treniņu
        return $this->belongsTo(User::class);
    }

    public function workout()
    {
        // Saite uz treniņu, kas pabeigts
        return $this->belongsTo(Workout::class);
    }
}
