<?php

namespace App\Algorithms\v1\Cake;

use App\Models\v1\Cake\Cake;
use App\Models\v1\Ingridient\Ingridient;
use App\Parser\Cake\CakeParser;
use App\Services\Constant\Activity\ActivityAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CakeAlgo
{
    public function __construct(public ?Cake $cake = null) {}

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = $request->except('ingridients');
                $this->cake = Cake::create($data);
                $this->attachIngridients($request->ingridients);
                
                $this->cake->load([
                    'variant',
                    'ingridients',
                ]);
            });

            return success(CakeParser::first($this->cake));

        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request) {
        try {
            DB::transaction(function() use ($request){                
                $this->detachIngridients();
                $this->cake->update($request->except('ingridients'));
                $this->attachIngridients($request->ingridients);
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function destroy() {
        try {
            DB::transaction(function(){             
                $this->cake->ingridients()->detach();
                $this->cake->delete();
            });

            return success(CakeParser::first($this->cake));
        } catch (\Exception $e) {
            exception($e);
        }
    }

    // -------------------- PRIVATE FUNCTION --------------------

    private function attachIngridients($ingridients){
        $this->cake->ingridients()->attach($ingridients);

        foreach ($ingridients as $ingridient) {
            Ingridient::find($ingridient['ingridientId'])->decrement('quantity', $ingridient['quantity']);
        }
    }

    private function detachIngridients(){
        $this->cake->ingridients()->each(function($ingridient){
            $ingridient->increment('quantity', $ingridient->used->quantity);
        });
        $this->cake->ingridients()->detach();
    }
}
