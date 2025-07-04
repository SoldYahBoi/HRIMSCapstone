<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Get the employees for the department.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
