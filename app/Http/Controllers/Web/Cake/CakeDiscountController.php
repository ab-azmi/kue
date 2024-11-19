<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeDiscountAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeDiscountRequest;
use App\Models\Cake\CakeDiscount;
use App\Parser\Cake\CakeDiscountParser;
use Illuminate\Http\Request;

class CakeDiscountController extends Controller
{
    public function __construct(public $algo = new CakeDiscountAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $discounts= CakeDiscount::with('cake')->getOrPaginate($request, true);
        return success(CakeDiscountParser::briefs($discounts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CakeDiscountRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $discount = CakeDiscount::with('cake')->findOrFail($id);
        return success($discount);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CakeDiscountRequest $request, string $id)
    {
        $this->algo->discount = CakeDiscount::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->discount = CakeDiscount::findOrFail($id);
        return $this->algo->delete();
    }
}
