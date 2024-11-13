<?php

namespace App\Models\v1\Cake;

use App\Models\BaseModel;
use App\Models\v1\Cake\Traits\HasActivityCakeProperty;
use App\Models\v1\Ingridient\Ingridient;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cake extends BaseModel
{
    use HasActivityCakeProperty;
    
    // protected $table = '';
    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime'
    ];

    // -------------------- RELATIONSHIP --------------------
    public function ingridients(): BelongsToMany
    {
        return $this->belongsToMany(Ingridient::class, 'cake_ingridients', 'cake_id', 'ingridient_id')
            ->withPivot('quantity', 'unit');
    }

}
