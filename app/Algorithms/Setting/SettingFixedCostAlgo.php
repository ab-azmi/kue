<?php

namespace App\Algorithms\Setting;

use App\Models\Setting\SettingFixedCost;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingFixedCostAlgo
{
    /**
     * @param SettingFixedCost|int|null $fixedCost
     */
    public function __construct(public SettingFixedCost|int|null $fixedCost = null)
    {
        if (is_int($fixedCost)) {
            $this->fixedCost = SettingFixedCost::find($fixedCost);
            if (! $this->fixedCost) {
                errSettingFixedCostGet();
            }
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveFixedCost($request);

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Fixed Cost : '.$this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveFixedCost($request);

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Fixed Cost : '.$this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return JsonResponse|mixed
     */
    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->fixedCost->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $deleted = $this->fixedCost->delete();
                if (! $deleted) {
                    errSettingFixedCostDelete();
                }

                $this->fixedCost->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Fixed Cost : '.$this->fixedCost->id);
            });

            return success($this->fixedCost);
        } catch (\Exception $e) {
            exception($e);
        }
    }


    /** --- PRIVATE FUNCTIONS --- **/

    private function saveFixedCost($request)
    {
        $form = $request->only([
            'name',
            'description',
            'amount',
            'frequency',
        ]);

        if ($this->fixedCost) {
            $updated = $this->fixedCost->update($form);
            if (! $updated) {
                errSettingFixedCostUpdate();
            }

            return;
        }

        $this->fixedCost = SettingFixedCost::create($form);
        if (! $this->fixedCost) {
            errSettingFixedCostCreate();
        }

    }
}
