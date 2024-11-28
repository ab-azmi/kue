<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CakeIngredient extends BaseModel
{
    protected $table = 'cake_ingredients';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
    ];

    /** --- RELATIONSHIP --- */

    public function componentIngredients(): BelongsTo
    {
        return $this->belongsTo(CakeComponentIngredient::class, 'ingredientId');
    }

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cakeId');
    }
}
