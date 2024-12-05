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

        $query->where(function($query) use ($request, $searchByText){
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText && $request->has('searchIn')){
                switch ($request->searchIn) {
                    case 'employee':
                        $query->whereHas('employee', function ($query) use ($request) {
                            $query->where('name', 'like', "%$request->search%");
                        });
                        break;
                    case 'cakeVariant':
                        $query->whereHas('orders', function ($query) use ($request) {
                            $query->whereHas('cakeVariant', function ($query) use ($request) {
                                $query->where('name', 'like', "%$request->search%");
                            });
                        });
                        break;
                    case 'number':
                        $query->where('number', 'like', "%$request->search%");
                        break;
                    default:
                        break;
                }
            }

            if($request->has('fromTotalPrice') && $request->has('toTotalPrice')){
                $query->whereBetween('totalPrice', [$request->fromTotalPrice, $request->toTotalPrice]);
            }

            if($request->has('fromOrderPrice') && $request->has('toOrderPrice')){
                $query->whereBetween('orderPrice', [$request->fromOrderPrice, $request->toOrderPrice]);
            }

            if($request->has('fromQuantity') && $request->has('toQuantity')){
                $query->whereBetween('quantity', [$request->fromQuantity, $request->toQuantity]);
            }

            if($request->has('statusId'))
            {
                $query->where('statusId', $request->statusId);
            }

            if($request->has('employeeId')){
                $query->where('employeeId', $request->employeeId);
            }
        });

        if($request->has('orderBy') && $request->has('orderType')){
            $query->orderBy($request->orderBy, $request->orderType);
        }

        return $query;
    }

    public function scopeCountToday($query)
    {
        return $query->whereDate('createdAt', now())->count();
    }

    public function scopeCountThisMonth($query)
    {
        return $query->whereMonth('createdAt', now())->count();
    }

    public function scopeCountCakeSoldToday($query)
    {
        return $query->whereDate('createdAt', now())
                ->with('orders')
                ->get()
                ->sum(function($transaction){
                    return $transaction->orders->sum('quantity');
                });
    }

    public function scopeCountCakeSoldThisMonth($query)
    {
        return $query->whereMonth('createdAt', now())
                ->with('orders')
                ->get()
                ->sum(function($transaction){
                    return $transaction->orders->sum('quantity');
                });
    }
}
