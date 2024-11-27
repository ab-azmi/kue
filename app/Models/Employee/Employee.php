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
        self::DELETED_AT => 'datetime',
    ];

    /** RELATIONSHIP **/
    public function user(): HasOne
    {
        return $this->hasOne(EmployeeUser::class, 'employeeId');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'employeeId');
    }

    public function salary(): HasOne
    {
        return $this->hasOne(EmployeeSalary::class, 'employeeId');
    }

    /** --- SCOPES --- */

    public function scopeFilter($query, $request)
    {
        $searchByText = $this->hasSearch($request);

        return $query->ofDate('createdAt', $request->fromDate, $request->toDate)
            ->when($searchByText, function ($query) use ($request) {
                return $query->whereHas('user', function ($query) use ($request) {
                    return $query->where('name', 'like', "%" . $request->search . "%")
                        ->orWhere('email', 'like', "%" . $request->search . "%");
                })
                ->orWhere('address', 'like', "%" . $request->search . "%");
            })
            ->when($request->orderBy && $request->orderType, function ($query) use ($request) {
                return $query->orderBy($request->orderBy, $request->orderType);
            });
    }
}
