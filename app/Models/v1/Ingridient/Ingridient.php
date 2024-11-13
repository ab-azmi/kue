<?php

namespace App\Models\v1\Ingridient;

use App\Models\BaseModel;

class Ingridient extends BaseModel
{
    // protected $table = '';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

}
