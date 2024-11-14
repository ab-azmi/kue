<?php

namespace App\Models\v1\Cake;

use App\Models\BaseModel;
use App\Models\v1\Cake\Traits\HasActivityCakeProperty;
use App\Models\v1\Ingridient\Ingridient;
use App\Models\v1\Setting\CakeVariant;
use App\Models\v1\Transaction\Order;
use App\Models\v1\Transaction\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    // -------------------- RELATIONSHIP --------------------

    public function ingridients(): BelongsToMany
    {
        return $this->belongsToMany(Ingridient::class, 'cake_ingridients', 'cakeId', 'ingridientId')
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

}
