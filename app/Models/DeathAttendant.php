<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathAttendant extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendant_type',
        'other_attendant_type',
        'name',
        'title_or_position',
        'address',
        'attended_from',
        'attended_to',
        'attended_deceased',
        'death_time',
        'certification_date',
    ];

    // Relationships
    public function deathCertificate()
    {
        return $this->hasOne(DeathCertificate::class);
    }
}