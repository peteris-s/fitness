<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalorieLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'calories',
        'food_name',
        'description',
        'log_date',
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
