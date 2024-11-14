<?php

namespace App\Models\v1\Transaction;

use App\Models\BaseModel;
use App\Models\v1\Cake\Cake;
use App\Models\v1\Transaction\Traits\HasActivityOrderProperty;

class Order extends BaseModel
{
    use HasActivityOrderProperty;

    protected $table = 'orders';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    // ------------------------------ RELATIONSHIP ------------------------------

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transactionId');
    }

    public function cake()
    {
        return $this->belongsTo(Cake::class, 'cakeId');
    }

}
