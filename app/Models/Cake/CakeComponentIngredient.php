<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeComponentIngredientProperty;
use App\Parser\Cake\CakeComponentIngredientParser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CakeComponentIngredient extends BaseModel
{
    use HasActivityCakeComponentIngredientProperty;

    protected $table = 'cake_component_ingredients';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'price' => 'float',
        'expirationDate' => 'date',
    ];

    public $parserClass = CakeComponentIngredientParser::class;



    /** --- RELATIONSHIP --- */

    public function cakeIngredients(): HasMany
    {
        return $this->hasMany(CakeIngredient::class, 'ingredientId');
    }

    public function cakes(): BelongsToMany
    {
        return $this->belongsToMany(Cake::class, 'cake_ingredients', 'ingredientId', 'cakeId')
            ->withPivot(['quantity'])
            ->as('used');
    }

    /** --- SCOPES --- **/

    public function scopeFilter($query, $request)
    {
        $searchByText = $this->hasSearch($request);

        return $query->where(function($query) use ($request, $searchByText){
            $query->ofDate('createdAt', $request->fromDate, $request->toDate);

            if($searchByText) {
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('supplier', 'like', '%'.$request->search.'%');
            }

            if($request->has('orderBy') && $request->has('orderType')) {
                $query->orderBy($request->orderBy, $request->orderType);
            }
        });
    }



    /** --- FUNCTIONS --- **/

    public function incrementStock(int $quantity)
    {
        return $this->increment('quantity', $quantity);
    }

    public function decrementStock(int $quantity)
    {
        return $this->decrement('quantity', $quantity);
    }
}
