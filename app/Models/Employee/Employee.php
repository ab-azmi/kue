<?php

namespace App\Models\Employee;

use App\Models\BaseModel;
use App\Models\Employee\Traits\HasActivityEmployeeProperty;

class Employee extends BaseModel
{
    use HasActivityEmployeeProperty;

    protected $table = 'employees';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

}
