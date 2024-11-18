<?php

namespace App\Models\Setting;

use App\Models\BaseModel;
use App\Models\Cake\Cake;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CakeVariant extends BaseModel
{
    protected $table = 'cake_variants';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];


    /** --- RELATIONSHIP --- */

    public function cakes(): HasMany
    {
        return $this->hasMany(Cake::class);
    }
}
