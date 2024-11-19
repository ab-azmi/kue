<?php

namespace App\Models\Setting;

use App\Models\BaseModel;
use App\Models\Setting\Traits\HasActivitySettingFixedCostProperty;
use App\Observers\Setting\FixedCostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([FixedCostObserver::class])]
class SettingFixedCost extends BaseModel
{
    use HasActivitySettingFixedCostProperty;

    protected $table = 'fixed_costs';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

}
