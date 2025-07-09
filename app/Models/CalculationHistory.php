<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sport_name',
        'duration_minutes',
        'weight_kg',
        'calories_burned',
    ];
}
