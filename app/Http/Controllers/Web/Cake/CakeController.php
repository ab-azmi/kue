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
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $cakes = Cake::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);

        return success(CakeParser::briefs($cakes));
    }

    /**
     * @param CakeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CakeRequest $request)
    {
        $algo = new CakeAlgo();
        return $algo->create($request);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $cake = Cake::with([
            'variant',
            'ingredients',
            'discounts'
        ])->find($id);

        if (!$cake) {
            errCakeGet();
        }

        return success($cake);
    }

    /**
     * @param CakeRequest $request
     * @param string $id
     */
    public function update($id, CakeRequest $request)
    {
        $algo = new CakeAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeAlgo((int)$id);
        return $algo->delete();
    }

    public function COGS(CakeCOGSRequest $request)
    {
        $algo = new CakeAlgo();
        return $algo->COGS($request);
    }
}
