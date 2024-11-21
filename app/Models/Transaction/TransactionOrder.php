<?php

namespace App\Models\Transaction;

use App\Models\BaseModel;
use App\Models\Cake\Cake;
use App\Models\Transaction\Traits\HasActivityOrderProperty;

class TransactionOrder extends BaseModel
{
    use HasActivityOrderProperty;

    protected $table = 'transaction_orders';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'price' => 'float',
        'discount' => 'float',
        'totalPrice' => 'float',
    ];

    /** --- RELATIONSHIP --- */

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactionId');
    }

    public function cake()
    {
        return $this->belongsTo(Cake::class, 'cakeId');
    }

}
