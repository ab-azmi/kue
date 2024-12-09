<?php

namespace App\Models\Setting;

use App\Models\BaseModel;
use App\Models\Setting\Traits\HasActivitySettingProperty;
use App\Parser\Setting\SettingParser;

class Setting extends BaseModel
{
    use HasActivitySettingProperty;

    protected $table = 'settings';

    protected $guarded = ['id'];

    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
        self::DELETED_AT => 'datetime',
    ];

    public $parserClass = SettingParser::class;


    /** --- SCOPES --- **/

    public function scopeFilter($query, $request)
    {
        $searchBytext = $this->hasSearch($request);

        if($searchBytext){
            $query->where('description', 'like', '%'.$request->search.'%')
                ->orWhere('key', 'like', '%'.$request->search.'%')
                ->orWhere('value', 'like', '%'.$request->search.'%');
        }

        if($request->has('key') && $request->key) {
            $query->where('key', $request->key);
        }

        return $query;
    }
}
