<?php

namespace App\Http\Controllers\Web\v1\Cake;

use App\Http\Controllers\Controller;
use App\Models\v1\Cake\Cake;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cakes = Cake::with([
            'variant',
            'ingridients',
        ])->orderBy('createdAt', 'desc')->getOrPaginate($request, true);

        return success($cakes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cake = Cake::findOrFail($id);
        $cake->load([
            'variant',
            'ingridients',
        ]);

        return success($cake);
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
    public function destroy(string $id)
    {
        //
    }
}
