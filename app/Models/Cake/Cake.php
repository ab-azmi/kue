<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeProperty;
use App\Parser\Cake\CakeParser;
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
        'images' => 'array',
    ];

    public $parserClass = CakeParser::class;



    /** --- RELATIONSHIP --- */

    public function cakeIngredients(): HasMany
    {
        return $this->hasMany(CakeIngredient::class, 'cakeId');
    }

    public function componentIngredients(): BelongsToMany
    {
        return $this->belongsToMany(CakeComponentIngredient::class, 'cake_ingredients', 'cakeId', 'ingredientId')
            ->withPivot(['quantity'])
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



    /** --- SCOPES --- */

    public function scopeFilter($query, $request)
    {
        $searchByText = $this->hasSearch($request);

        return $query->where(function($query) use ($request, $searchByText) {
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText) {
                $query->where('name', 'like', '%'.$request->search.'%');
            }

            if($request->has('variantId')){
                $query->whereHas('variants', function ($query) use ($request) {
                    return $query->where('id', $request->variantId);
                });
            }

            if($request->has('orderBy') && $request->has('orderType')){
                $query->orderBy($request->orderBy, $request->orderType);
            }
        });

    }
}
