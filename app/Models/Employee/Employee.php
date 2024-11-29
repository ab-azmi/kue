<?php

namespace App\Models\Employee;

use App\Models\BaseModel;
use App\Models\Employee\Traits\HasActivityEmployeeProperty;
use App\Models\Transaction\Transaction;
use App\Parser\Employee\EmployeeParser;
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

    public $parserClass = EmployeeParser::class;



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

        return $query->where(function($query) use ($request, $searchByText){
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText){
                $query->whereHas('user', function ($query) use ($request) {
                    return $query->where('email', 'like', '%'.$request->search.'%');
                })->orWhere('name', 'like', '%'.$request->search.'%')
                    ->orWhere('address', 'like', '%'.$request->search.'%');
            }

            if($request->has('orderBy') && $request->has('orderType')){
                $query->orderBy($request->orderBy, $request->orderType);
            }
        });
    }


    /** --- FUNCTIONS --- */

    public function getProfileLink()
    {
        if(!$this->profile){
            return null;
        }

        return storage_link($this->profile);
    }
}
