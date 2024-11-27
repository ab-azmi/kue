<?php

namespace App\Models\Employee;

use App\Models\BaseModel;
use App\Models\Employee\Traits\HasActivityEmployeeSalaryProperty;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeSalary extends BaseModel
{
    use HasActivityEmployeeSalaryProperty;

    protected $table = 'employee_salaries';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'totalSalary' => 'float',
    ];

    public $parserClass = EmployeeSalary::class;


    /** --- RELATIONSHIP --- */

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }


    /** --- FUNCTIONS --- */

    //function to get the sum of totalSalary of all employees
    public static function getTotalSalary(): float
    {
        return self::sum('totalSalary');
    }
}
