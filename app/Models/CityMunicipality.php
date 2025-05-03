<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CityMunicipality extends Model
{
    use HasFactory;

    protected $table = 'cities_municipalities';

    protected $fillable = [
        'name',
        'province_id',
        'is_city', // boolean to distinguish between city and municipality
    ];

    /**
     * Get the province this city/municipality belongs to.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}