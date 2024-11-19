<?php

namespace App\Models\Employee;

use App\Models\BaseModel;
use App\Models\Employee\EmployeeUser;
use App\Models\Employee\Traits\HasActivityEmployeeSalaryProperty;
use App\Observers\Salary\SalaryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([SalaryObserver::class])]
class EmployeeSalary extends BaseModel
{
    use HasActivityEmployeeSalaryProperty;
    
    protected $table = 'employee_salaries';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    /** --- RELATIONSHIP --- */

    public function user(): BelongsTo
    {
        return $this->belongsTo(EmployeeUser::class, 'userId');
    }

}
