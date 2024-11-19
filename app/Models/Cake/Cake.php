<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeProperty;
use App\Models\Cake\CakeComponentIngridient;
use App\Models\Cake\CakeVariant;
use App\Models\Transaction\Order;
use App\Models\Transaction\Transaction;
use App\Observers\Cake\CakeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ObservedBy([CakeObserver::class])]
class Cake extends BaseModel
{
    use HasActivityCakeProperty;

    protected $table = 'cakes';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    /** --- RELATIONSHIP --- */

    public function ingridients(): BelongsToMany
    {
        return $this->belongsToMany(CakeComponentIngridient::class, 'cake_ingridients', 'cakeId', 'ingridientId')
            ->withPivot('quantity', 'unit')
            ->as('used');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(CakeVariant::class, 'cakeVariantId');
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class, 'cakeId');
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Order::class, Transaction::class, 'cakeId', 'transactionId');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(CakeDiscount::class, 'cakeId');
    }

}
