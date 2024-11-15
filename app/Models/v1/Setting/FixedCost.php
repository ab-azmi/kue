<?php

namespace App\Models\v1\Setting;

use App\Models\BaseModel;
use App\Models\v1\Setting\Traits\HasActivityFixedCostProperty;
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
