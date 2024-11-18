<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\FixedCostAlgo;
use App\Http\Controllers\Controller;
use App\Models\Setting\FixedCost;
use App\Parser\Setting\FixedCostParser;
use Illuminate\Http\Request;

class FixedCostController extends Controller
{
    public function __construct(public $algo = new FixedCostAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $fixedcosts = FixedCost::orderBy('createdAt')->getOrPaginate($request, true);
        return success($fixedcosts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $fixedcost = FixedCost::findOrFail($id);
        return success(FixedCostParser::first($fixedcost));
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
    public function delete(string $id)
    {
        $this->algo->fixedCost = FixedCost::findOrFail($id);
        return $this->algo->delete();
    }
}
