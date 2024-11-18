<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\DiscountAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Discount\DiscountRequest;
use App\Models\Cake\Discount;
use App\Parser\Cake\DiscountParser;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(public $algo = new DiscountAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $discounts= Discount::with('cake')->getOrPaginate($request, true);
        return success(DiscountParser::briefs($discounts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(DiscountRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $discount = Discount::with('cake')->findOrFail($id);
        return success($discount);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, string $id)
    {
        $this->algo->discount = Discount::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->discount = Discount::findOrFail($id);
        return $this->algo->delete();
    }
}
