<?php

namespace App\Http\Controllers\Web\v1\Setting;

use App\Algorithms\v1\Setting\FixedCostAlgo;
use App\Http\Controllers\Controller;
use App\Models\v1\Setting\FixedCost;
use Illuminate\Http\Request;

class FixedCostController extends Controller
{
    public function __construct(public $algo = new FixedCostAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $fixedcosts = FixedCost::orderBy('createdAt')->getOrPaginate($request, true);
        return success($fixedcosts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fixedcost = FixedCost::findOrFail($id);
        return success($fixedcost);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->algo->fixedCost = FixedCost::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->algo->fixedCost = FixedCost::findOrFail($id);
        return $this->algo->delete();
    }
}
