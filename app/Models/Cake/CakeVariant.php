<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeVariantProperty;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionOrder;
use App\Parser\Cake\CakeVariantParser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CakeVariant extends BaseModel
{
    use HasActivityCakeVariantProperty;

    protected $table = 'cake_variants';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'price' => 'float',
    ];

    public $parserClass = CakeVariantParser::class;



    /** --- RELATIONSHIP --- */

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cakeId');
    }

    public function order(): HasMany
    {
        return $this->hasMany(TransactionOrder::class, 'cakeVariantId');
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(TransactionOrder::class, Transaction::class, 'cakeVariantId', 'transactionId');
    }



    /** --- SCOPES --- */

    public function scopeFilter($query, $request)
    {
        $searchByText = $this->hasSearch($request);

        $query->where(function($query) use ($request, $searchByText){
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText){
                switch($request->searchIn){
                    case 'cake':
                        $query->whereHas('cake', function($query) use ($request){
                            $query->where('name', 'like', "%$request->searchText%");
                        });
                        break;
                    default:
                        $query->where('name', 'like', '%'.$request->search.'%');
                        break;
                }
            }

            if($request->has('cakeId')){
                $query->where('cakeId', $request->cakeId);
            }

            if($request->has('fromPrice') && $request->has('toPrice')){
                $query->whereBetween('price', [$request->fromPrice, $request->toPrice]);
            }

            if($request->has('fromCakePrice') && $request->has('toCakePrice')){
                $query->whereHas('cake', function($query) use ($request){
                    $query->whereBetween('sellingPrice', [$request->fromCakePrice, $request->toCakePrice]);
                });
            }

            if($request->has('hasDiscount')){
                $query->whereHas('cake', function($query){
                    $query->whereHas('discounts');
                });
            }
        });

        if($request->has('orderBy') && $request->has('orderType')){
            return $query->orderBy($request->orderBy, $request->orderType);
        }

        return $query;
    }
}
