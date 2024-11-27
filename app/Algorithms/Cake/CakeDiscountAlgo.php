<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\CakeDiscount;
use App\Parser\Cake\CakeDiscountParser;
use App\Services\Constant\Activity\ActivityAction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
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
            if (! $this->discount) {
                errCakeDiscountGet();
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
                $this->saveDiscount($request);

                $this->discount->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Discount : '.$this->discount->id);
            });

            return success($this->discount);
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
                $this->discount->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveDiscount($request);

                $this->discount->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Discount : '.$this->discount->id);
            });

            return success($this->discount);
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

            $this->discount->setOldActivityPropertyAttributes(ActivityAction::DELETE);

            $this->discount->delete();

            $this->discount->setActivityPropertyAttributes(ActivityAction::DELETE)
                ->saveActivity('Delete Discount : '.$this->discount->id);

            return success();
        } catch (\Exception $e) {
            exception($e);
        }
    }


    /** --- PRIVATE FUNCTIONS --- **/

    private function saveDiscount(Request $request)
    {
        $form = $request->only([
            'name',
            'description',
            'value',
            'cakeId',
        ]);

        $form['fromDate'] = Carbon::createFromFormat('d/m/Y', $request->fromDate)->startOfDay();
        $form['toDate'] = Carbon::createFromFormat('d/m/Y', $request->toDate)->endOfDay();

        if ($this->discount) {
            $updated = $this->discount->update($form);
            if (! $updated) {
                errCakeUpdate();
            }

            return;
        }

        $this->discount = CakeDiscount::create($form);
        if (! $this->discount) {
            errCakeCreate();
        }
    }
}
