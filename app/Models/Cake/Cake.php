<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeProperty;
use App\Models\Cake\CakeComponentIngredient;
use App\Models\Cake\CakeVariant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cake extends BaseModel
{
    use HasActivityCakeProperty;

    protected $table = 'cakes';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'profitMargin' => 'float',
        'COGS' => 'float',
        'sellingPrice' => 'float',
    ];

    /** --- RELATIONSHIP --- */

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(CakeComponentIngredient::class, 'cake_ingredients', 'cakeId', 'ingredientId')
            ->withPivot(['quantity', 'isActive'])
            ->as('used');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(CakeDiscount::class, 'cakeId');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(CakeVariant::class, 'cakeId');
    }

}
