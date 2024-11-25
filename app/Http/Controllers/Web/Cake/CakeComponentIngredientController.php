<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeComponentIngredientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeComponentIngredientRequest;
use App\Models\Cake\CakeComponentIngredient;
use App\Parser\Cake\CakeComponentIngredientParser;
use Illuminate\Http\Request;

class CakeComponentIngredientController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $ingredients = CakeComponentIngredient::orderBy('createdAt', 'desc')
            ->getOrPaginate($request, true);

        return success(CakeComponentIngredientParser::briefs($ingredients));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CakeComponentIngredientRequest $request)
    {
        $algo = new CakeComponentIngredientAlgo;

        return $algo->create($request);
    }

    /**
     * @param  string|int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $ingredient = CakeComponentIngredient::findOrFail($id);

        return success(CakeComponentIngredientParser::first($ingredient));
    }

    /**
     * @param  string|int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CakeComponentIngredientRequest $request)
    {
        $algo = new CakeComponentIngredientAlgo((int) $id);

        return $algo->update($request);
    }

    /**
     * @param  string|int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeComponentIngredientAlgo((int) $id);

        return $algo->delete();
    }
}
