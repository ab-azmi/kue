<?php

namespace App\Algorithms\Cake;

use App\Models\Cake\CakeVariant;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Support\Facades\DB;

class CakeVariantAlgo
{
    /**
     * CakeVariantAlgo constructor.
     * @param CakeVariant|int|null $cakeVariant
     */
    public function __construct(public CakeVariant|int|null $cakeVariant = null)
    {
        if(is_int($cakeVariant)) {
            $this->cakeVariant = CakeVariant::find($cakeVariant);
            if(!$this->cakeVariant) {
                errCakeVariantGet();
            }
        }
    }

    public function create($request)
    {
        try {
            DB::transaction(function() use ($request) {
                $this->saveCakeVariant($request);

                $this->cakeVariant->setActivityPropertyAttributes(ActivityAction::CREATE)
                        ->saveActivity('Create new Cake : '.$this->cakeVariant->id);
            });

            return success($this->cakeVariant);
        }catch(\Exception $e) {
            exception($e);
        }
    }



    /** --- PRIVATE FUNCTION --- */

    private function saveCakeVariant($request)
    {
        $form = $request->only([
            'name',
            'price',
            'cakeId'
        ]);

        if($this->cakeVariant) {
            $updated = $this->cakeVariant->update($form);
            if(!$updated) {
                errCakeVariantUpdate();
            }
            return;
        }

        $created = CakeVariant::create($form);
        if(!$created) {
            errCakeVariantCreate();
        }
    }
}
