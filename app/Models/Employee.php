<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
