<?php

namespace App\Models\Transaction;

use App\Models\BaseModel;
use App\Models\Employee\Employee;
use App\Models\Transaction\Traits\HasActivityTransactionProperty;
use App\Observers\Transaction\TransactionObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

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

    /** --- RELATIONSHIP --- */

    public function orders()
    {
        return $this->hasMany(TransactionOrder::class, 'transactionId');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employeeId');
    }
}
