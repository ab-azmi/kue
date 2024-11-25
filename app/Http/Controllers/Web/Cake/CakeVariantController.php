<?php

namespace App\Http\Controllers\Web\Cake;

use App\Http\Controllers\Controller;
use App\Models\Cake\CakeVariant;
use Illuminate\Http\Request;

class CakeVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $variants = CakeVariant::filter($request)->getOrPaginate($request, true);

        return success($variants);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        //
    }
}
