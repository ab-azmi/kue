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
        'isActive' => 'boolean',
    ];

}
