<?php

namespace App\Http\Controllers\Web\v1\Cake;

use App\Algorithms\v1\Cake\DiscountAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Discount\CreateDiscountRequest;
use App\Http\Requests\v1\Discount\UpdateDiscountRequest;
use App\Models\v1\Cake\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(public $algo = new DiscountAlgo())
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $discounts= Discount::with('cake')->getOrPaginate($request, true);
        return success($discounts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDiscountRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $discount = Discount::with('cake')->findOrFail($id);
        return success($discount);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, string $id)
    {
        $this->algo->discount = Discount::findOrFail($id);
        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->algo->discount = Discount::findOrFail($id);
        return $this->algo->delete();
    }
}
