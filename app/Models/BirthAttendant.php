<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BirthAttendant extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendant_type', // 1-Physician, 2-Nurse, 3-Midwife, 4-Hilot, 5-Others
        'other_attendant_type', // If attendant_type is 5-Others
        'signature',
        'name',
        'title_or_position',
        'address',
        'certification_date',
        'birth_time', // am/pm format
    ];

    /**
     * Get the birth certificates associated with the birth attendant.
     */
    public function birthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class);
    }
}