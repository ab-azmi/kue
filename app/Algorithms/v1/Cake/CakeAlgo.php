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
                $this->cake->ingridients()->sync($request->ingridients);

                $this->syncIngridientStock($request->ingridients);
                $this->cake->load([
                    'variant',
                    'ingridients',
                ]);
                
                $this->cake->setActivityPropertyAttributes(ActivityAction::CREATE)
                    ->saveActivity('Create new Cake : ' . $this->cake->id);
            });
            
            return success(CakeParser::first($this->cake));

        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function update(Request $request) {}

    public function destroy() {}

    // -------------------- PRIVATE FUNCTION --------------------

    private function syncIngridientStock($ingridients){
        foreach ($ingridients as $ingridient) {
            Ingridient::find($ingridient['ingridientId'])->decrement('quantity', $ingridient['quantity']);
        }
    }
}
