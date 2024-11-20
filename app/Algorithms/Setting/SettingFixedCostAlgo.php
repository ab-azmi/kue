<?php

namespace App\Algorithms\Setting;

use App\Models\Setting\SettingFixedCost;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingFixedCostAlgo
{
    public function __construct(public ?SettingFixedCost $fixedCost = null) {}

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->fixedCost = SettingFixedCost::create($request->all());

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errCreateFixedCost($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->fixedCost->update($request->all());

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errUpdateFixedCost($e->getMessage());
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->fixedCost->delete();

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errDeleteFixedCost($e->getMessage());
        }
    }
}
