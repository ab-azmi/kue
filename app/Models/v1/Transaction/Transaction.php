<?php

namespace App\Models\v1\Transaction;

use App\Models\BaseModel;
use App\Models\v1\Transaction\Traits\HasActivityTransactionProperty;
use App\Models\v1\User\User;
use App\Observers\Transaction\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([TransactionObserver::class])]
class Transaction extends BaseModel
{
    use HasActivityTransactionProperty;

    protected $table = 'transactions';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    // ------------------------------ RELATIONSHIP ------------------------------

    public function orders()
    {
        return $this->hasMany(Order::class, 'transactionId');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'cashierId');
    }
}
