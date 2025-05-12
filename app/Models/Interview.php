<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'interviewer_id',
        'interview_date',
        'start_time',
        'end_time',
        'location',
        'interview_type',
        'status',
        'feedback',
        'rating'
    ];

    protected $casts = [
        'interview_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'rating' => 'integer'
    ];

    /**
     * The possible interview types.
     */
    public const INTERVIEW_TYPES = [
        'phone' => 'Phone',
        'video' => 'Video',
        'in_person' => 'In Person',
        'panel' => 'Panel'
    ];

    /**
     * The possible statuses for an interview.
     */
    public const STATUSES = [
        'scheduled' => 'Scheduled',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'rescheduled' => 'Rescheduled',
        'no_show' => 'No Show'
    ];

    /**
     * Get the application that owns the interview.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the interviewer that owns the interview.
     */
    public function interviewer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class, 'interviewer_id');
    }
}