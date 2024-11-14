<?php

namespace App\Algorithms\v1\Setting;

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
                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::UPDATE);
                $this->fixedCost->update($request->all());
                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function delete(){
        try {
            DB::transaction(function(){
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::DELETE);
                $this->fixedCost->delete();
                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}