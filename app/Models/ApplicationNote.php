<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'user_id',
        'content'
    ];

    /**
     * Get the application that owns the note.
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the user that created the note.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}