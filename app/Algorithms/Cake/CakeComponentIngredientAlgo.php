<?php
namespace App\Algorithms\Cake;

use App\Models\Cake\CakeComponentIngredient;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeComponentIngredientAlgo
{
    /**
     * @param CakeComponentIngredient|int|null
     */
    public function __construct(public CakeComponentIngredient|int|null $ingredient = null)
    {
        if(is_int($ingredient)){
            $this->ingredient = CakeComponentIngredient::find($ingredient);
            if(!$this->ingredient){
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

                $this->ingredient->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Ingredient : ' . $this->ingredient->id);
            });
            return success($this->ingredient);
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
                $this->ingredient->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->saveIngredient($request);

                $this->ingredient->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Ingredient : ' . $this->ingredient->id);
            });
            return success($this->ingredient);
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
                $this->ingredient->setOldActivityPropertyAttributes(ActivityAction::DELETE);

                $ids = $this->ingredient->cakes->pluck('id')->toArray();
                $this->ingredient->cakes()->updateExistingPivot($ids, ['isActive' => false]);
                
                $this->ingredient->delete();

                $this->ingredient->setActivityPropertyAttributes(ActivityAction::DELETE)
                    ->saveActivity('Delete Ingredient : ' . $this->ingredient->id);
            });
            return success($this->ingredient);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /** --- PRIVATE FUNCTIONS --- **/

    private function saveIngredient(Request $request){
        $form = $request->safe()->only([
            'name', 'unitId', 'price', 'expirationDate', 'quantity', 'supplier'
        ]);

        if($this->ingredient){
            $updated = $this->ingredient->update($form);
            if(!$updated){
                errCakeIngredientUpdate();
            }
        } else {
            $this->ingredient = CakeComponentIngredient::create($form);
            if(!$this->ingredient){
                errCakeIngredientCreate();
            }
        }
    }
}