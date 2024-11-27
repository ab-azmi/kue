<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeComponentIngredientAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeComponentIngredientRequest;
use App\Models\Cake\CakeComponentIngredient;
use App\Parser\Cake\CakeComponentIngredientParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CakeComponentIngredientController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $ingredients = CakeComponentIngredient::filter($request)->getOrPaginate($request, true);

        return success(CakeComponentIngredientParser::briefs($ingredients), pagination: pagination($ingredients));
    }

    /**
     * @param CakeComponentIngredientRequest $request
     *
     * @return JsonResponse|mixed
     */
    public function create(CakeComponentIngredientRequest $request)
    {
        $algo = new CakeComponentIngredientAlgo;

        return $algo->create($request);
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function detail($id)
    {
        $ingredient = CakeComponentIngredient::with('cakes')->find($id);
        if(!$ingredient) {
            errCakeIngredientGet();
        }

        return success(CakeComponentIngredientParser::first($ingredient));
    }

    /**
     * @param  string  $id
     * @param  CakeComponentIngredientRequest  $request
     *
     * @return JsonResponse
     */
    public function update($id, CakeComponentIngredientRequest $request)
    {
        $algo = new CakeComponentIngredientAlgo((int) $id);

        return $algo->update($request);
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeComponentIngredientAlgo((int) $id);

        return $algo->delete();
    }
}
