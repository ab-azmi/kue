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

        return $query->ofDate('createdAt', $request->fromDate, $request->toDate)
            ->when($searchByText, function ($query) use ($request) {
                return $query->where('number', 'like', "%".$request->search."%");
            })
            ->when($request->employeeId, function ($query) use ($request) {
                return $query->where('employeeId', $request->employeeId);
            })
            ->when($request->orderBy && $request->orderType, function ($query) use ($request) {
                return $query->orderBy($request->orderBy, $request->orderType);
            });
    }
}
