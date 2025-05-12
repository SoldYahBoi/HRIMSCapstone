<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'open_positions',
        'new_applications',
        'interviews_scheduled',
        'positions_filled',
        'total_applications',
        'avg_time_to_hire',
        'acceptance_rate',
        'cost_per_hire'
    ];

    protected $casts = [
        'date' => 'date',
        'avg_time_to_hire' => 'integer',
        'acceptance_rate' => 'decimal:2',
        'cost_per_hire' => 'decimal:2'
    ];
}