<?php

namespace App\Algorithms\Setting;

use App\Models\Setting\SettingFixedCost;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingFixedCostAlgo
{
    public function __construct(public SettingFixedCost|int|null $fixedCost = null)
    {
        if (is_int($fixedCost)) {
            $this->fixedCost = SettingFixedCost::find($fixedCost);
            if (!$this->fixedCost) {
                errGetFixedCost();
            }
        }
    }

    /**
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveFixedCost($request);

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errCreateFixedCost($e->getMessage());
        }
    }

    /**
     * @param Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveFixedCost($request);

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Fixed Cost : ' . $this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            return errUpdateFixedCost($e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
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

    /** --- PRIVATE FUNCTIONS --- **/

    private function saveFixedCost($request)
    {
        $form = $request->safe()->only([
            'name',
            'description',
            'amount',
            'frequency',
        ]);

        if($this->fixedCost) {
            $updated = $this->fixedCost->update($form);
            if (!$updated) {
                return errUpdateFixedCost();
            }
        } else {
            $this->fixedCost = SettingFixedCost::create($form);
            if (!$this->fixedCost) {
                return errCreateFixedCost();
            }
        }
    }
}
