<?php
namespace App\Algorithms\Cake;

use App\Models\Cake\CakeComponentIngridient;
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