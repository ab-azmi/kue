<?php

namespace App\Http\Controllers\Web\v1\Ingridient;

use App\Algorithms\v1\Ingridient\IngridientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Ingridient\CreateIngridientRequest;
use App\Http\Requests\v1\Ingridient\UpdateIngridientRequest;
use App\Models\v1\Ingridient\Ingridient;
use Illuminate\Http\Request;

class IngridientController extends Controller
{
    public function __construct(public $algo = new IngridientAlgo())
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ingridients = Ingridient::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);
        
        return success($ingridients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIngridientRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ingridient = Ingridient::findOrFail($id);
        return success($ingridient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngridientRequest $request, string $id)
    {
        $this->algo->ingridient = Ingridient::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->algo->ingridient = Ingridient::findOrFail($id);
        return $this->algo->destroy();
    }
}
