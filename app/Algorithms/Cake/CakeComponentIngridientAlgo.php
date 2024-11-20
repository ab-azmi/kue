<?php
namespace App\Algorithms\Cake;

use App\Models\Cake\CakeComponentIngridient;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeComponentIngridientAlgo
{
    public function __construct(public ?CakeComponentIngridient $ingridient = null)
    {
    }

    public function store(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->ingridient = CakeComponentIngridient::create($request->validated());

                $this->ingridient->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Ingridient : ' . $this->ingridient->id);
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->ingridient->setOldActivityPropertyAttributes(ActivityAction::UPDATE);

                $this->ingridient->update($request->validated());

                $this->ingridient->setActivityPropertyAttributes(ActivityAction::UPDATE)
                    ->saveActivity('Update Ingridient : ' . $this->ingridient->id);
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }
    
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
}