<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathCause extends Model
{
    use HasFactory;

    protected $fillable = [
        'immediate_cause',
        'antecedent_cause',
        'underlying_cause',
        'other_significant_conditions',
        'interval_between_onset_and_death',
        'maternal_condition',
        'manner_of_death',
        'external_cause_place',
        'autopsy_performed',
    ];

    // Relationships
    public function deathCertificate()
    {
        return $this->hasOne(DeathCertificate::class);
    }
}