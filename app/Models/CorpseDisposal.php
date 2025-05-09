<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorpseDisposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'disposal_type',
        'other_disposal_type',
        'burial_cremation_permit_number',
        'burial_cremation_permit_date',
        'transfer_permit_number',
        'transfer_permit_date',
        'cemetery_name',
        'cemetery_address',
    ];

    // Relationships
    public function deathCertificate()
    {
        return $this->hasOne(DeathCertificate::class);
    }
}