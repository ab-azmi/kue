<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionOrder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class CakeVariant extends BaseModel
{
    protected $table = 'cake_variants';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'price' => 'float',
    ];

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
}
