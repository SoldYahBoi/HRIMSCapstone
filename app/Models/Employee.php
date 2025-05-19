<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    //
    protected $fillable = [
        "first_name",
        "middle_name",
        "last_name",
        "birthdate",
        "gender",
        "civil_status",
        "contact_number",
        "email",
        "address",
        "department_id",
        "position_id",
        "hire_date",
        "status",
        "employment_type_id"
    ];

    /**
     * Get the department that owns the employee.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position that owns the employee.
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }
}
