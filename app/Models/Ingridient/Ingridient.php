<?php

namespace App\Models\Ingridient;

use App\Models\BaseModel;
use App\Models\Cake\Cake;
use App\Models\Ingridient\Traits\HasActivityIngridientProperty;
use App\Observers\Ingridient\IngridientObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([IngridientObserver::class])]
class Ingridient extends BaseModel
{
    use HasActivityIngridientProperty;
    
    protected $table = 'ingridients';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    /** --- RELATIONSHIP --- */

    public function cakes(): BelongsToMany
    {
        return $this->belongsToMany(Cake::class, 'cake_ingridients', 'ingridientId', 'cakeId')
            ->withPivot('quantity', 'unit')
            ->as('used');
    }

}
