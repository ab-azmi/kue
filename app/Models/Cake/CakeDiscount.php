<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeDiscountProperty;
use App\Models\Cake\Traits\HasActivityDiscountProperty;
use App\Observers\Cake\DiscountObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CakeDiscount extends BaseModel
{
    use HasActivityCakeDiscountProperty;

    protected $table = 'cake_discounts';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'fromDate' => 'datetime',
        'toDate' => 'datetime',
    ];
    
    /** --- RELATIONSHIP --- */

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cakeId', 'id');
    }
}
