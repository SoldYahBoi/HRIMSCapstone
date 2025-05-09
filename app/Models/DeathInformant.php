<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeathInformant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relationship_to_deceased',
        'address',
        'date',
    ];

    // Relationships
    public function deathCertificate()
    {
        return $this->hasOne(DeathCertificate::class);
    }
}