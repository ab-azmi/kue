<?php

namespace App\Models\v1\User;

use App\Models\BaseModel;
use App\Models\v1\Salary\Salary;
use App\Models\v1\User\Traits\HasActivityUserProperty;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    // ------------------------------ RELATIONSHIP ------------------------------

    public function salary(): HasOne
    {
        return $this->hasOne(Salary::class, 'userId');
    }

}
