<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BirthCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'registry_no',
        'province_id',
        'city_municipality_id',
        'child_id',
        'mother_id',
        'father_id',
        'marriage_id',
        'birth_attendant_id',
        'informant_id',
        'prepared_by_id',
        'received_by_id',
        'registered_by_id',
        'remarks',
        'contact_no',
    ];

    /**
     * Get the child associated with the birth certificate.
     */
    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    /**
     * Get the mother associated with the birth certificate.
     */
    public function mother(): BelongsTo
    {
        return $this->belongsTo(Mother::class);
    }

    /**
     * Get the father associated with the birth certificate.
     */
    public function father(): BelongsTo
    {
        return $this->belongsTo(Father::class);
    }

    /**
     * Get the marriage details associated with the birth certificate.
     */
    public function marriage(): BelongsTo
    {
        return $this->belongsTo(Marriage::class);
    }

    /**
     * Get the birth attendant associated with the birth certificate.
     */
    public function birthAttendant(): BelongsTo
    {
        return $this->belongsTo(BirthAttendant::class);
    }

    /**
     * Get the informant associated with the birth certificate.
     */
    public function informant(): BelongsTo
    {
        return $this->belongsTo(Informant::class);
    }

    /**
     * Get the person who prepared the birth certificate.
     */
    public function preparedBy(): BelongsTo
    {
        return $this->belongsTo(Official::class, 'prepared_by_id');
    }

    /**
     * Get the person who received the birth certificate.
     */
    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(Official::class, 'received_by_id');
    }

    /**
     * Get the person who registered the birth certificate.
     */
    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(Official::class, 'registered_by_id');
    }

    /**
     * Get the province associated with the birth certificate.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the city/municipality associated with the birth certificate.
     */
    public function cityMunicipality(): BelongsTo
    {
        return $this->belongsTo(CityMunicipality::class);
    }
}