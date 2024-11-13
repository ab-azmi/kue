<?php

namespace App\Models\v1\Setting;

use App\Models\BaseModel;
use App\Models\v1\Cake\Cake;
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


    // -------------------- RELATIONSHIP --------------------

    public function cakes(): HasMany
    {
        return $this->hasMany(Cake::class);
    }
}
