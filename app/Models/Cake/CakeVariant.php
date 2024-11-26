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

        return $query->ofDate('createdAt', $request->fromDate, $request->toDate)
            ->when($searchByText, function ($query) use ($request) {
                return $query->where('name', 'like', '%'.$request->search.'%');

                return $query->where('description', 'like', '%'.$request->search.'%');
            })
            ->when($request->cakeId, function ($query) use ($request) {
                return $query->where('cakeId', $request->cakeId);
            });
    }
}
