<?php

namespace App\Models\Setting;

use App\Models\BaseModel;
use App\Models\Setting\Traits\HasActivityFixedCostProperty;
use App\Observers\Setting\FixedCostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([FixedCostObserver::class])]
class FixedCost extends BaseModel
{
    use HasActivityFixedCostProperty;

    protected $table = 'fixed_costs';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

}
