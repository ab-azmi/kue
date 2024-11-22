<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeComponentIngredientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeComponentIngredientRequest;
use App\Models\Cake\CakeComponentIngredient;
use Illuminate\Http\Request;

class CakeComponentIngredientController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $ingredients = CakeComponentIngredient::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);
        
        return success($ingredients);
    }

    /**
     * @param CakeComponentIngredientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CakeComponentIngredientRequest $request)
    {
        $algo = new CakeComponentIngredientAlgo();
        return $algo->create($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $ingredient = CakeComponentIngredient::findOrFail($id);
        return success($ingredient);
    }

    /**
     * @param string|int $id
     * @param CakeComponentIngredientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CakeComponentIngredientRequest $request)
    {
        $algo = new CakeComponentIngredientAlgo((int)$id);
        return $algo->update($request);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeComponentIngredientAlgo((int)$id);
        return $algo->delete();
    }
}
