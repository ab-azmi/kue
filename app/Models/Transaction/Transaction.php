<?php

namespace App\Models\Transaction;

use App\Models\BaseModel;
use App\Models\Employee\Employee;
use App\Models\Transaction\Traits\HasActivityTransactionProperty;
use App\Parser\Transaction\TransactionParser;

class Transaction extends BaseModel
{
    use HasActivityTransactionProperty;

    protected $table = 'transactions';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'orderPrice' => 'float',
        'totalDiscount' => 'float',
        'tax' => 'float',
        'totalPrice' => 'float',
    ];

    public $parserClass = TransactionParser::class;


    /** --- RELATIONSHIP --- */

    public function orders()
    {
        return $this->hasMany(TransactionOrder::class, 'transactionId');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }


    /** --- SCOPES --- */

    public function scopeFilter($query, $request)
    {
        $searchByText = $this->hasSearch($request);

        return $query->where(function($query) use ($request, $searchByText){
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText){
                $query->where('number', 'like', '%'.$request->search.'%');
            }

            if($request->has('employeeId')){
                $query->where('employeeId', $request->employeeId);
            }

            if($request->has('orderBy') && $request->has('orderType')){
                $query->orderBy($request->orderBy, $request->orderType);
            }
        });
    }
}
