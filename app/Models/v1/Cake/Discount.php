<?php

namespace App\Models\v1\Cake;

use App\Models\BaseModel;
use App\Models\v1\Cake\Traits\HasActivityDiscountProperty;
use App\Observers\Cake\DiscountObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([DiscountObserver::class])]
class Discount extends BaseModel
{
    use HasActivityDiscountProperty;

    protected $table = 'discounts';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];
    
    //----------------------------------- RELATIONSHIP -----------------------------------//

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cakeId', 'id');
    }
}
