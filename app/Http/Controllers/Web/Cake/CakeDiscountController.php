<?php

namespace App\Http\Controllers\Web\Cake;

use App\Algorithms\Cake\CakeDiscountAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cake\CakeDiscountRequest;
use App\Models\Cake\CakeDiscount;
use App\Parser\Cake\CakeDiscountParser;
use Illuminate\Http\Request;

class CakeDiscountController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $discounts= CakeDiscount::with('cake')->getOrPaginate($request, true);
        return success(CakeDiscountParser::briefs($discounts));
    }

    /**
     * @param CakeDiscountRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CakeDiscountRequest $request)
    {
        $algo = new CakeDiscountAlgo();
        return $algo->create($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $discount = CakeDiscount::with('cake')->find($id);
        if (!$discount) {
            errCakeDiscountGet();
        }
        return success($discount);
    }

    /**
     * @param $id
     * @param CakeDiscountRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CakeDiscountRequest $request)
    {
        $algo = new CakeDiscountAlgo($id);
        return $algo->update($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $algo = new CakeDiscountAlgo($id);
        return $algo->delete();
    }
}
