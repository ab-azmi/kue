<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Cake;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CakeVariant extends BaseModel
{
    protected $table = 'cake_variants';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'price' => 'float',
    ];


    /** --- RELATIONSHIP --- */

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cakeId');
    }
}
