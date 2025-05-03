<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Official extends Model
{
    use HasFactory;

    protected $fillable = [
        'signature',
        'name',
        'title_or_position',
        'date',
    ];

    /**
     * Get the birth certificates prepared by this official.
     */
    public function preparedBirthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class, 'prepared_by_id');
    }

    /**
     * Get the birth certificates received by this official.
     */
    public function receivedBirthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class, 'received_by_id');
    }

    /**
     * Get the birth certificates registered by this official.
     */
    public function registeredBirthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class, 'registered_by_id');
    }
}