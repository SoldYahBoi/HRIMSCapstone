<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Marriage extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'place_city_municipality_id',
        'place_province_id',
        'place_country_id',
    ];

    /**
     * Get the birth certificates associated with the marriage.
     */
    public function birthCertificates(): HasMany
    {
        return $this->hasMany(BirthCertificate::class);
    }

    /**
     * Get the city/municipality of marriage.
     */
    public function placeCityMunicipality()
    {
        return $this->belongsTo(CityMunicipality::class, 'place_city_municipality_id');
    }

    /**
     * Get the province of marriage.
     */
    public function placeProvince()
    {
        return $this->belongsTo(Province::class, 'place_province_id');
    }

    /**
     * Get the country of marriage.
     */
    public function placeCountry()
    {
        return $this->belongsTo(Country::class, 'place_country_id');
    }
}