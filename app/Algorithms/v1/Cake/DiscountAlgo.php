<?php
namespace App\Algorithms\v1\Cake;

use App\Models\v1\Cake\Discount;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountAlgo
{
    public function __construct(public ?Discount $discount = null)
    {
        
    }

    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->discount = Discount::create($request->all());
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