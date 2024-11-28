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


    /** --- FUNCTIONS --- */

    public function getImageLinks()
    {
        return array_map(function($image) {
            return storage_link($image);
        }, $this->images);
    }

    public function getComponentIngredients()
    {
        return CakeComponentIngredient::whereIn('id', $this->cakeIngredients->pluck('ingredientId'))->get();
    }
}
