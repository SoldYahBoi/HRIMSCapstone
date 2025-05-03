<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'date_of_birth',
        'place_of_birth_hospital',
        'place_of_birth_city_municipality_id',
        'place_of_birth_province_id',
        'type_of_birth', // Single, Twin, Triplet, etc.
        'birth_order', // First, Second, Third, etc. (for multiple births)
        'is_multiple_birth',
        'multiple_birth_type', // First, Second, Third, etc. (if multiple birth)
        'weight_at_birth',
    ];

    /**
     * Get the birth certificate associated with the child.
     */
    public function birthCertificate(): HasOne
    {
        return $this->hasOne(BirthCertificate::class);
    }

    /**
     * Get the city/municipality of birth.
     */
    public function birthCityMunicipality()
    {
        return $this->belongsTo(CityMunicipality::class, 'place_of_birth_city_municipality_id');
    }

    /**
     * Get the province of birth.
     */
    public function birthProvince()
    {
        return $this->belongsTo(Province::class, 'place_of_birth_province_id');
    }
}