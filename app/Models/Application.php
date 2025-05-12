<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'job_posting_id',
        'application_code',
        'cover_letter',
        'status',
        'applied_date',
        'reviewed_date',
        'reviewed_by'
    ];

    protected $casts = [
        'applied_date' => 'date',
        'reviewed_date' => 'date',
    ];

    /**
     * The possible statuses for an application.
     */
    public const STATUSES = [
        'new' => 'New',
        'reviewing' => 'Reviewing',
        'interview' => 'Interview',
        'hired' => 'Hired',
        'rejected' => 'Rejected'
    ];

    /**
     * Get the applicant that owns the application.
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Get the job posting that owns the application.
     */
    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id')->with('position');
    }

    /**
     * Get the interviews for the application.
     */
    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }

    /**
     * Get the notes for the application.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(ApplicationNote::class);
    }
    
    /**
     * Get the reviewer that reviewed the application.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}