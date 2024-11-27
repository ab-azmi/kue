<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeVariantAlgo;
use App\Http\Controllers\Controller;
use App\Models\Cake\CakeVariant;
use App\Parser\Cake\CakeVariantParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CakeVariantController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $variants = CakeVariant::filter($request)->getOrPaginate($request, true);

        return success($variants, pagination: pagination($variants));
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed|null
     */
    public function create(Request $request)
    {
        $algo = new CakeVariantAlgo();
        return $algo->create($request);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse|mixed
     */
    public function detail(string $id)
    {
        $cakeVariant = CakeVariant::find($id);
        if(!$cakeVariant) {
            errCakeVariantGet();
        }

        return success(CakeVariantParser::first($cakeVariant));
    }

    /**
     * @param Request $request
     * @param string $id
     *
     * @return JsonResponse|mixed|null
     */
    public function update(Request $request, string $id)
    {
        $algo = new CakeVariantAlgo($id);
        return $algo->update($request);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse|mixed|null
     */
    public function delete(string $id)
    {
        $algo = new CakeVariantAlgo($id);
        return $algo->delete();
    }
}
