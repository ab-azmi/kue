<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\CakeDiscount;
use App\Parser\Cake\CakeDiscountParser;
use App\Services\Constant\Activity\ActivityAction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeDiscountAlgo
{
    /**
     * @param CakeDiscount|int|null $discount
     */
    public function __construct(public CakeDiscount|int|null $discount = null)
    {
        if (is_int($discount)) {
            $this->discount = CakeDiscount::find($discount);
            if (!$this->discount) {
                errCakeDiscountGet();
            }
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->saveDiscount($request);

                $this->discount->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Discount : ' . $this->discount->id);
            });

            return success(CakeDiscountParser::brief($this->discount));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->discount->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveDiscount($request);

                $this->discount->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Discount : ' . $this->discount->id);
            });

            return success(CakeDiscountParser::brief($this->discount));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse|mixed|void
     */
    public function delete()
    {
        try {
            DB::transaction(function () {
                $this->discount->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->discount->delete();

                $this->discount->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Discount : ' . $this->discount->id);
            });

            return success(CakeDiscountParser::brief($this->discount));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- **/

    private function saveDiscount(Request $request)
    {
        $form = $request->safe()->only([
            'name',
            'description',
            'value',
            'cakeId',
        ]);

        $form['fromDate'] = Carbon::createFromFormat('d/m/Y', $request->fromDate);
        $form['toDate'] = Carbon::createFromFormat('d/m/Y', $request->toDate);

        if ($this->discount) {
            $this->discount->update($form);
            $this->discount->refresh();
            return;
        }

        $this->discount = CakeDiscount::create($form);
        if (!$this->discount) {
            errCakeCreate();
        }
    }

    private function getDates(Request $request)
    {
        $fromDate = date('Y-m-d H:i:s', strtotime($request->fromDate));
        $toDate = date('Y-m-d H:i:s', strtotime($request->toDate));

        if ($fromDate > $toDate) {
            errCakeCreate('From date must be less than to date');
        }

        return [
            'from' => $fromDate,
            'to' => $toDate,
        ];
    }

}
