<?php
namespace App\Algorithms\v1\Ingridient;

use App\Models\v1\Ingridient\Ingridient;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IngridientAlgo
{
    public function __construct(public ?Ingridient $ingridient = null)
    {
    }

    public function store(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->ingridient = Ingridient::create($request->validated());

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
    
    public function destroy(){
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