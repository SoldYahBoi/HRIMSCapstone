<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_id',
        'department_id',
        'location',
        'employment_type',
        'description',
        'requirements',
        'benefits',
        'salary_range',
        'application_deadline',
        'is_active',
        'status'
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * The possible statuses for a job posting.
     */
    public const STATUSES = [
        'open' => 'Open',
        'closed' => 'Closed',
        'filled' => 'Filled',
        'cancelled' => 'Cancelled',
        'draft' => 'Draft'
    ];

    /**
     * The possible employment types.
     */
    public const EMPLOYMENT_TYPES = [
        'full-time' => 'Full-time',
        'part-time' => 'Part-time',
        'contract' => 'Contract',
        'temporary' => 'Temporary'
    ];

    /**
     * Get the position that owns the job posting.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the department that owns the job posting.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the applications for the job posting.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}