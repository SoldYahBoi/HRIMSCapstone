<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deceased extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'date_of_birth',
        'date_of_death',
        'age_years',
        'age_months',
        'age_days',
        'age_hours',
        'age_minutes',
        'place_of_death',
        'civil_status',
        'religion',
        'citizenship',
        'residence_house_no',
        'residence_street',
        'residence_barangay',
        'residence_city_municipality_id',
        'residence_province_id',
        'residence_country_id',
        'occupation',
        'father_name',
        'mother_maiden_name',
    ];

    // Relationships
    public function deathCertificate()
    {
        return $this->hasOne(DeathCertificate::class);
    }

    public function residenceCity()
    {
        return $this->belongsTo(CityMunicipality::class, 'residence_city_municipality_id');
    }

    public function residenceProvince()
    {
        return $this->belongsTo(Province::class, 'residence_province_id');
    }

    public function residenceCountry()
    {
        return $this->belongsTo(Country::class, 'residence_country_id');
    }
}