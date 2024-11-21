<?php
namespace App\Algorithms\Cake;

use App\Models\Cake\CakeComponentIngridient;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeComponentIngridientAlgo
{
    public function __construct(public CakeComponentIngridient|int|null $ingridient = null)
    {
        if(is_int($ingridient)){
            $this->ingridient = CakeComponentIngridient::find($ingridient);
            if(!$this->ingridient){
                errCakeIngredientGet();
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->saveIngredient($request);

                $this->ingridient->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Ingridient : ' . $this->ingridient->id);
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->ingridient->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveIngredient($request);

                $this->ingridient->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Ingridient : ' . $this->ingridient->id);
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }
    
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(){
        try {
            DB::transaction(function(){
                $this->ingridient->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $this->ingridient->cakes()->detach();
                
                $this->ingridient->delete();

                $this->ingridient->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Ingridient : ' . $this->ingridient->id);
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- **/

    private function saveIngredient(Request $request){
        $form = $request->safe()->only([
            'name', 'unitId', 'price', 'expirationDate', 'quantity', 'supplier'
        ]);

        if($this->ingridient){
            $updated = $this->ingridient->update($form);
            if(!$updated){
                errCakeIngredientUpdate();
            }
        } else {
            $this->ingridient = CakeComponentIngridient::create($form);
            if(!$this->ingridient){
                errCakeIngredientCreate();
            }
        }
    }
}