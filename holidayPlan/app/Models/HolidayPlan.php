<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'date', 'location', 'participants'
    ];

    protected $casts = [
        'participants' => 'array',
        'date' => 'date:Y-m-d',
    ];
}
