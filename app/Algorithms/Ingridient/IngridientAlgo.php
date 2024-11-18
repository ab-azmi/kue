<?php
namespace App\Algorithms\Ingridient;

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
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request){
        try {
            DB::transaction(function() use ($request){
                $this->ingridient->update($request->validated());
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }
    
    public function destroy(){
        try {
            DB::transaction(function(){
                $this->ingridient->cakes()->detach();
                $this->ingridient->delete();
            });
            return success($this->ingridient);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}