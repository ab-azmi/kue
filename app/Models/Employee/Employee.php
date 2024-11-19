<?php

namespace App\Models\Employee;

use App\Models\BaseModel;
use App\Models\Employee\Traits\HasActivityEmployeeProperty;
use App\Models\Transaction\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /** RELATIONSHIP **/

    public function user(): BelongsTo
    {
        return $this->belongsTo(EmployeeUser::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'employeeId');
    }

    public function salary(): HasOne
    {
        return $this->hasOne(EmployeeSalary::class, 'employeeId');
    }
}
