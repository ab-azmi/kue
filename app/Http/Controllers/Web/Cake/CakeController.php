<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeCOGSRequest;
use App\Http\Requests\Cake\CakeRequest;
use App\Models\Cake\Cake;
use App\Parser\Cake\CakeParser;
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
        $cakes = Cake::orderBy('createdAt', 'desc')
        ->getOrPaginate($request, true);

        return success(CakeParser::briefs($cakes));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(CakeRequest $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $cake = Cake::find($id);

        if (!$cake) {
            return errGetCake();
        }

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
        $cake = Cake::find($id);

        if (!$cake) {
            return errGetCake();
        }

        $this->algo->cake = $cake;

        return $this->algo->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $cake = Cake::find($id);

        if (!$cake) {
            return errGetCake();
        }

        $this->algo->cake = $cake;

        return $this->algo->delete();
    }

    public function COGS(CakeCOGSRequest $request)
    {
        return $this->algo->COGS($request);
    }
}
