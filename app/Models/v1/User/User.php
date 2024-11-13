<?php

namespace App\Models\v1\User;

use App\Models\BaseModel;
use App\Models\v1\User\Traits\HasActivityUserProperty;

class User extends BaseModel
{
    use HasActivityUserProperty;
    
    protected $table = 'users';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

}
