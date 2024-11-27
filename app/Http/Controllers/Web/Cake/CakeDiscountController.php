<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeDiscountAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeDiscountRequest;
use App\Models\Cake\CakeDiscount;
use App\Parser\Cake\CakeDiscountParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CakeDiscountController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $discounts = CakeDiscount::filter($request)->getOrPaginate($request, true);

        return success(CakeDiscountParser::briefs($discounts));
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function detail($id)
    {
        $discount = CakeDiscount::with('cake')->find($id);
        if (! $discount) {
            errCakeDiscountGet();
        }

        return success($discount);
    }

    /**
     * @param CakeDiscountRequest $request
     *
     * @return JsonResponse|mixed
     */
    public function create(CakeDiscountRequest $request)
    {
        $algo = new CakeDiscountAlgo;
        return $algo->create($request);
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function update($id, CakeDiscountRequest $request)
    {
        $algo = new CakeDiscountAlgo($id);
        return $algo->update($request);
    }

    /**
     * @return JsonResponse|mixed
     */
    public function delete($id)
    {
        $algo = new CakeDiscountAlgo($id);
        return $algo->delete();
    }
}
