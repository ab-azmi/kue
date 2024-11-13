<?php

namespace App\Models\v1\Ingridient;

use App\Models\BaseModel;
use App\Models\v1\Cake\Cake;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingridient extends BaseModel
{
    protected $table = 'ingridients';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    // -------------------- RELATIONSHIP --------------------

    public function cakes(): BelongsToMany
    {
        return $this->belongsToMany(Cake::class, 'cake_ingridients', 'ingridientId', 'cakeId')
            ->withPivot('quantity', 'unit')
            ->as('used');
    }

}
