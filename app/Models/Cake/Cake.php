<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeProperty;
use App\Models\Cake\CakeComponentIngridient;
use App\Models\Cake\CakeVariant;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionOrder;
use App\Observers\Cake\CakeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cake extends BaseModel
{
    use HasActivityCakeProperty;

    protected $table = 'cakes';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'profitMargin' => 'float',
        'COGS' => 'float',
        'sellingPrice' => 'float',
    ];

    /** --- RELATIONSHIP --- */

    public function ingridients(): BelongsToMany
    {
        return $this->belongsToMany(CakeComponentIngridient::class, 'cake_ingridients', 'cakeId', 'ingridientId')
            ->withPivot(['quantity', 'isActive'])
            ->as('used');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(CakeVariant::class, 'cakeVariantId');
    }

    public function order(): HasMany
    {
        return $this->hasMany(TransactionOrder::class, 'cakeId');
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(TransactionOrder::class, Transaction::class, 'cakeId', 'transactionId');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(CakeDiscount::class, 'cakeId');
    }

}
