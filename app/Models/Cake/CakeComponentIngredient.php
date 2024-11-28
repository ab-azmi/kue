<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeComponentIngredientProperty;
use App\Parser\Cake\CakeComponentIngredientParser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

        return $query->ofDate('createdAt', $request->fromDate, $request->toDate)
            ->when(
                $searchByText,
                function ($query) use ($request) {
                    return $query->where('name', 'like', '%'.$request->search.'%')
                        ->orWhere('supplier', 'like', '%'.$request->search.'%');
                }
            )
            ->when($request->orderBy, function ($query) use ($request) {
                return $query->orderBy($request->orderBy, $request->orderType);
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

    public function adjustQuantity($quantity)
    {
        $this->quantity = $this->quantity + $quantity;
        $this->save();
    }

}
