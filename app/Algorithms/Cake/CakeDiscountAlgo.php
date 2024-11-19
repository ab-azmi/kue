<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\CakeDiscount;
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
                $this->discount->update($request->all());
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
                $this->discount->delete();
            });

            return success($this->discount);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}
