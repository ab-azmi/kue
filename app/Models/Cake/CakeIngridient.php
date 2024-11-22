<?php

namespace App\Models\Cake;

use App\Models\BaseModel;

class CakeIngridient extends BaseModel
{
    protected $table = 'cake_ingridients';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'isActive' => 'boolean',
    ];

}
