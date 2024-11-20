<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeComponentIngridientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeComponentIngridientRequest;
use App\Models\Cake\CakeComponentIngridient;
use Illuminate\Http\Request;

class CakeComponentIngridientController extends Controller
{
    public function __construct(public $algo = new CakeComponentIngridientAlgo())
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $ingridients = CakeComponentIngridient::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);
        
        return success($ingridients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CakeComponentIngridientRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $ingridient = CakeComponentIngridient::findOrFail($id);
        return success($ingridient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CakeComponentIngridientRequest $request, string $id)
    {
        $this->algo->ingridient = CakeComponentIngridient::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->ingridient = CakeComponentIngridient::findOrFail($id);
        return $this->algo->delete();
    }
}
