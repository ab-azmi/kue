<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeComponentIngridientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeComponentIngridientRequest;
use App\Models\Cake\CakeComponentIngridient;
use Illuminate\Http\Request;

class CakeComponentIngridientController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $ingridients = CakeComponentIngridient::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);
        
        return success($ingridients);
    }

    /**
     * @param CakeComponentIngridientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CakeComponentIngridientRequest $request)
    {
        $algo = new CakeComponentIngridientAlgo();
        return $algo->create($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $ingridient = CakeComponentIngridient::findOrFail($id);
        return success($ingridient);
    }

    /**
     * @param string|int $id
     * @param CakeComponentIngridientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CakeComponentIngridientRequest $request)
    {
        $algo = new CakeComponentIngridientAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeComponentIngridientAlgo((int)$id);
        return $algo->delete();
    }
}
