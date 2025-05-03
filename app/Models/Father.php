<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Father extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'citizenship',
        'religion',
        'occupation',
        'age_at_birth',
        'residence_house_no',
        'residence_street',
        'residence_barangay',
        'residence_city_municipality_id',
        'residence_province_id',
        'residence_country_id',
    ];

    /**
     * Get the birth certificates associated with the father.
     */
    public function birthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class);
    }

    /**
     * Get the city/municipality of residence.
     */
    public function residenceCityMunicipality()
    {
        return $this->belongsTo(CityMunicipality::class, 'residence_city_municipality_id');
    }

    /**
     * Get the province of residence.
     */
    public function residenceProvince()
    {
        return $this->belongsTo(Province::class, 'residence_province_id');
    }

    /**
     * Get the country of residence.
     */
    public function residenceCountry()
    {
        return $this->belongsTo(Country::class, 'residence_country_id');
    }
}