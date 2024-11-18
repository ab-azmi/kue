<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeRequest;
use App\Http\Requests\Cake\COGSRequest as CakeCOGSRequest;
use App\Models\Cake\Cake;
use Illuminate\Http\Request;

class CakeController extends Controller
{
    public function __construct(public $algo = new CakeAlgo())
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $cakes = Cake::with([
            'variant',
            'ingridients',
            'discounts',
        ])->orderBy('createdAt', 'desc')
        ->getOrPaginate($request, true);

        return success($cakes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CakeRequest $request)
    {
        return $this->algo->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $cake = Cake::findOrFail($id);
        $cake->load([
            'variant',
            'ingridients',
            'discounts'
        ]);

        return success($cake);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CakeRequest $request, string $id)
    {
        $cake = Cake::findOrFail($id);
        $this->algo->cake = $cake;

        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $cake = Cake::findOrFail($id);
        $this->algo->cake = $cake;

        return $this->algo->destroy();
    }

    public function cogs(CakeCOGSRequest $request)
    {
        return $this->algo->COGS($request);
    }
}
