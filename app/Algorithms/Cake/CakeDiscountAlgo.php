<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\CakeDiscount;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeDiscountAlgo
{
    public function __construct(public ?CakeDiscount $discount = null) {}

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $fromData = date('Y-m-d H:i:s', strtotime($request->fromDate));
                $toDate = date('Y-m-d H:i:s', strtotime($request->toDate));

                $data = array_merge($request->all(), ['fromDate' => $fromData, 'toDate' => $toDate]);

                $this->discount = CakeDiscount::create($data);

                $this->discount->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Discount : ' . $this->discount->id);
            });

            return success($this->discount);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->discount->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->discount->update($request->all());

                $this->discount->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Discount : ' . $this->discount->id);
            });

            return success($this->discount);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->discount->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->discount->delete();

                $this->discount->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Discount : ' . $this->discount->id);
            });

            return success($this->discount);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}
