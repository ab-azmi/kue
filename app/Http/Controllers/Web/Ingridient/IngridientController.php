<?php

namespace App\Http\Controllers\Web\Ingridient;

use App\Algorithms\Ingridient\IngridientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Ingridient\IngridientRequest;
use App\Models\Ingridient\Ingridient;
use Illuminate\Http\Request;

class IngridientController extends Controller
{
    public function __construct(public $algo = new IngridientAlgo())
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $ingridients = Ingridient::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);
        
        return success($ingridients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(IngridientRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $ingridient = Ingridient::findOrFail($id);
        return success($ingridient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IngridientRequest $request, string $id)
    {
        $this->algo->ingridient = Ingridient::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->ingridient = Ingridient::findOrFail($id);
        return $this->algo->destroy();
    }
}
