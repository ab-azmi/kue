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

        return $query->where(function($query) use ($request, $searchByText){
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText){
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            }

            if($request->has('cakeId')){
                $query->where('cakeId', $request->cakeId);
            }
        });
    }
}
