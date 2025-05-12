<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicantDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'document_type',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'uploaded_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    /**
     * The possible document types.
     */
    public const DOCUMENT_TYPES = [
        'resume' => 'Resume',
        'cover_letter' => 'Cover Letter',
        'certification' => 'Certification',
        'license' => 'License',
        'other' => 'Other'
    ];

    /**
     * Get the applicant that owns the document.
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }
}