<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\SettingFixedCostAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingFixedCostRequest;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Setting\FixedCostParser;
use Illuminate\Http\Request;

class SettingFixedCostController extends Controller
{
    public function __construct(public $algo = new SettingFixedCostAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $fixedcosts = SettingFixedCost::orderBy('createdAt')->getOrPaginate($request, true);
        return success($fixedcosts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(SettingFixedCostRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $fixedcost = SettingFixedCost::findOrFail($id);
        return success(FixedCostParser::first($fixedcost));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SettingFixedCostRequest $request, string $id)
    {
        $this->algo->fixedCost = SettingFixedCost::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->fixedCost = SettingFixedCost::findOrFail($id);
        return $this->algo->delete();
    }
}
