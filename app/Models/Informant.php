<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Informant extends Model
{
    use HasFactory;

    protected $fillable = [
        'signature',
        'name',
        'relationship_to_child',
        'address',
        'date',
    ];

    /**
     * Get the birth certificates associated with the informant.
     */
    public function birthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class);
    }
}