<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'country_id',
    ];

    /**
     * Get the cities/municipalities in this province.
     */
    public function citiesMunicipalities(): HasMany
    {
        return $this->hasMany(CityMunicipality::class);
    }

    /**
     * Get the country this province belongs to.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}