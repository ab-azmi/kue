<?php

namespace App\Models\v1\Cake;

use App\Models\BaseModel;
use App\Models\v1\Cake\Traits\HasActivityCakeProperty;
use App\Models\v1\Ingridient\Ingridient;
use App\Models\v1\Setting\CakeVariant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cake extends BaseModel
{
    use HasActivityCakeProperty;

    protected $table = 'cakes';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    // -------------------- RELATIONSHIP --------------------

    public function ingridients(): BelongsToMany
    {
        return $this->belongsToMany(Ingridient::class, 'cake_ingridients', 'cakeId', 'ingridientId')
            ->withPivot('quantity', 'unit');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(CakeVariant::class, 'cakeVariantId');
    }

}
