<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeComponentIngredientProperty;
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

    /** --- RELATIONSHIP --- */
    public function cakes(): BelongsToMany
    {
        return $this->belongsToMany(Cake::class, 'cake_ingredients', 'ingredientId', 'cakeId')
            ->withPivot(['quantity', 'isActive'])
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
}
