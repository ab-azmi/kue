<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Cake;
use App\Models\Cake\Traits\HasActivityCakeComponentIngridientProperty;
use App\Observers\Cake\IngridientObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CakeComponentIngridient extends BaseModel
{
    use HasActivityCakeComponentIngridientProperty;
    
    protected $table = 'cake_component_ingridients';
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
