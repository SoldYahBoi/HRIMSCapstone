<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'registry_no',
        'province_id',
        'city_municipality_id',
        'deceased_id',
        'death_cause_id',
        'death_attendant_id',
        'death_informant_id',
        'corpse_disposal_id',
        'prepared_by_id',
        'received_by_id',
        'registered_by_id',
        'reviewed_by_id',
        'remarks',
        'contact_no',
    ];

    // Relationships
    public function deceased()
    {
        return $this->belongsTo(Deceased::class);
    }

    public function deathCause()
    {
        return $this->belongsTo(DeathCause::class);
    }

    public function deathAttendant()
    {
        return $this->belongsTo(DeathAttendant::class);
    }

    public function deathInformant()
    {
        return $this->belongsTo(DeathInformant::class);
    }

    public function corpseDisposal()
    {
        return $this->belongsTo(CorpseDisposal::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function cityMunicipality()
    {
        return $this->belongsTo(CityMunicipality::class);
    }

    public function preparedBy()
    {
        return $this->belongsTo(Official::class, 'prepared_by_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(Official::class, 'received_by_id');
    }

    public function registeredBy()
    {
        return $this->belongsTo(Official::class, 'registered_by_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(Official::class, 'reviewed_by_id');
    }
}