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

        $query->where(function($query) use ($request, $searchByText) {
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText) {
                switch($request->searchIn) {
                    case 'cakeVariant':
                        $query->whereHas('variants', function($query) use ($request) {
                            $query->where('name', 'like', '%'.$request->search.'%');
                        });
                        break;
                    case 'ingredient':
                        $query->whereHas('cakeIngredients', function($query) use ($request) {
                            $query->whereHas('ingredient', function($query) use ($request) {
                                $query->where('name', 'like', '%'.$request->search.'%')
                                    ->orWhere('supplier', 'like', '%'.$request->search.'%');
                            });
                        });
                        break;
                    case 'discount':
                        $query->whereHas('discounts', function($query) use ($request) {
                            $query->where('name', 'like', '%'.$request->search.'%');
                        });
                        break;
                    default:
                        $query->where('name', 'like', '%'.$request->search.'%');
                        break;
                }

            }

            if($request->has('fromCOGS') && $request->has('toCOGS')) {
                $query->whereBetween('COGS', [$request->fromCOGS, $request->toCOGS]);
            }

            if($request->has('fromSellingPrice') && $request->has('toSellingPrice')) {
                $query->whereBetween('sellingPrice', [$request->fromSellingPrice, $request->toSellingPrice]);
            }

            if($request->has('fromTotalDiscount') && $request->has('toTotalDiscount')) {
                $query->whereBetween('totalDiscount', [$request->fromTotalDiscount, $request->toTotalDiscount]);
            }

            if($request->has('fromStockSell') && $request->has('toStockSell')){
                $query->whereBetween('stockSell', [$request->fromStockSell, $request->toStockSell]);
            }

            if($request->has('fromStockNonSell') && $request->has('toStockNonSell')){
                $query->whereBetween('stockNonSell', [$request->fromStockNonSell, $request->toStockNonSell]);
            }

            if($request->has('hasDiscount')){
                $query->whereHas('discounts', function($query) use ($request){
                    $query->where('fromDate', '<=', now())
                        ->where('toDate', '>=', now());
                });
            }

            if($request->has('isSell')) {
                $query->isSell($request->isSell);
            }
        });

        if($request->has('orderBy') && $request->has('orderType')){
            return $query->orderBy($request->orderBy, $request->orderType);
        }

        return $query;
    }

    public function scopeIsSell($query, $isSell)
    {
        return $query->where('isSell', $isSell);
    }


    /** --- FUNCTIONS --- */

    public function getImageLinks()
    {
        return array_map(function($image) {
            return storage_link($image);
        }, $this->images);
    }

    public function adjustStockSell(int $quantity)
    {
        $this->stockSell += $quantity;
        $this->save();
    }

    public function adjustStockNonSell(int $quantity)
    {
        $this->stockNonSell += abs($quantity);
        $this->save();
    }

    public function getTotalDiscount()
    {
        return $this->discounts()
            ->where('fromDate', '<=', now())
            ->where('toDate', '>=', now())
            ->sum('value');
    }

    public function getComponentIngredients()
    {
        return CakeComponentIngredient::whereIn('id', $this->cakeIngredients->pluck('ingredientId'))
            ->get()->map(function($ingredient) {
                $ingredient->pivot = [
                    'quantity' => $this->cakeIngredients->where('ingredientId', $ingredient->id)->first()->quantity
                ];
                return $ingredient;
            });
    }
}
