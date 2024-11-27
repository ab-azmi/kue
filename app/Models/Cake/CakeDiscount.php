<?php

namespace App\Models\Cake;

use App\Models\BaseModel;
use App\Models\Cake\Traits\HasActivityCakeDiscountProperty;
use App\Parser\Cake\CakeDiscountParser;
use App\Services\Constant\Path\Path;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CakeDiscount extends BaseModel
{
    use HasActivityCakeDiscountProperty;

    protected $table = 'cake_discounts';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'fromDate' => 'datetime',
        'toDate' => 'datetime',
        'value' => 'float',
    ];

    public $parserClass = CakeDiscountParser::class;


    /** --- RELATIONSHIP --- */

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cakeId', 'id');
    }


    /** --- SCOPES --- **/

    public function scopeFilter($query, $request)
    {
        $searchBytext = $this->hasSearch($request);

        return $query->where(function($query) use ($request, $searchBytext) {
            if($searchBytext){
                $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            }

            if($request->has('fromDate') && $request->has('toDate')){
                $query->where('fromDate', '>=', Carbon::createFromFormat('d/m/Y', $request->fromDate)->toDateString())
                    ->where('toDate', '<=', Carbon::createFromFormat('d/m/Y', $request->toDate)->toDateString());
            }

            if($request->has('cakeId')){
                $query->where('cakeId', $request->cakeId);
            }
        });
    }
}
