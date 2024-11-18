<?php

namespace App\Algorithms\Setting;

use App\Models\v1\Setting\FixedCost;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FixedCostAlgo
{
    public function __construct(public ?FixedCost $fixedCost = null)
    {
    }

    public function create(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->fixedCost = FixedCost::create($request->all());
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->fixedCost->update($request->all());
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function delete(){
        try {
            DB::transaction(function(){
                $this->fixedCost->delete();
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}