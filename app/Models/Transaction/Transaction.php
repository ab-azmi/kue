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

            if($request->has('totalPriceFrom') && $request->has('totalPriceTo')){
                $query->whereBetween('totalPrice', [$request->totalPriceFrom, $request->totalPriceTo]);
            }

            if($request->has('orderPriceFrom') && $request->has('orderPriceTo')){
                $query->whereBetween('orderPrice', [$request->orderPriceFrom, $request->orderPriceTo]);
            }

            if($request->has('quantityFrom') && $request->has('quantityTo')){
                $query->whereBetween('quantity', [$request->quantityFrom, $request->quantityTo]);
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
}
