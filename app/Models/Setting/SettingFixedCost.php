<?php

namespace App\Models\Setting;

use App\Models\BaseModel;
use App\Models\Setting\Traits\HasActivitySettingFixedCostProperty;
use App\Parser\Setting\SettingFixedCostParser;

class SettingFixedCost extends BaseModel
{
    use HasActivitySettingFixedCostProperty;

    protected $table = 'setting_fixed_costs';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
        'amount' => 'float',
    ];

    public $parserClass = SettingFixedCostParser::class;


    /** --- SCOPES --- **/

    public function scopeFilter($query, $request)
    {
        $searchBytext = $this->hasSearch($request);

        return $query->ofDate('createdAt', $request->fromDate, $request->toDate)
            ->when($searchBytext, function ($query) use ($request) {
                return $query->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('description', 'like', '%'.$request->search.'%');
            })
            ->when($request->has('frequency'), function ($query) use ($request) {
                return $query->where('frequency', $request->frequency);
            })
            ->when($request->orderBy && $request->orderType, function ($query) use ($request) {
                return $query->orderBy($request->orderBy, $request->orderType);
            });
    }



    /** --- FUNCTIONS --- **/

    public static function getFixedCostMonthly(): float
    {
        return self::where('frequency', 'monthly')->sum('amount');
    }
}
