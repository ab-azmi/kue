<?php

namespace App\Models\Salary;

use App\Models\BaseModel;
use App\Models\Employee\EmployeeUser;
use App\Models\Salary\Traits\HasActivitySalaryProperty;
use App\Observers\Salary\SalaryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([SalaryObserver::class])]
class Salary extends BaseModel
{
    use HasActivitySalaryProperty;
    
    protected $table = 'salaries';
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
