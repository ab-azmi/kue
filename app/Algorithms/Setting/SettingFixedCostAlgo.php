<?php

namespace App\Algorithms\Setting;

use App\Models\Setting\SettingFixedCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingFixedCostAlgo
{
    public function __construct(public ?SettingFixedCost $fixedCost = null)
    {
    }

    public function create(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->fixedCost = SettingFixedCost::create($request->all());
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errCreateFixedCost($e->getMessage());
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->fixedCost->update($request->all());
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errUpdateFixedCost($e->getMessage());
        }
    }

    public function delete(){
        try {
            DB::transaction(function(){
                $this->fixedCost->delete();
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errDeleteFixedCost($e->getMessage());
        }
    }
}