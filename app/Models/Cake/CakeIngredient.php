<?php

namespace App\Models\Cake;

use App\Models\BaseModel;

class CakeIngredient extends BaseModel
{
    protected $table = 'cake_ingredients';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
    ];

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }

    public function ingredeint()
    {
        return $this->belongsTo(CakeComponentIngredient::class);
    }

    public function delete()
    {
        $this->ingredeint->ingredient->adjustQuantity($this->quantity * $this->cake->stock);

        return parent::delete();
    }
}
