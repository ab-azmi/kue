<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\SettingFixedCostAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Setting\SettingFixedCostRequest;
use App\Models\Setting\SettingFixedCost;
use App\Parser\Setting\SettingFixedCostParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingFixedCostController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function get(Request $request)
    {
        $fixedCosts = SettingFixedCost::filter($request)->getOrPaginate($request, true);

        return success($fixedCosts, pagination: pagination($fixedCosts));
    }

    /**
     * @param SettingFixedCostRequest $request
     *
     * @return JsonResponse
     */
    public function create(SettingFixedCostRequest $request)
    {
        $algo = new SettingFixedCostAlgo;

        return $algo->create($request);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function detail($id)
    {
        $fixedCost = SettingFixedCost::find($id);
        if (! $fixedCost) {
            errSettingFixedCostGet();
        }

        return success($fixedCost);
    }

    /**
     * @param string $id
     * @param SettingFixedCostRequest $request
     *
     * @return JsonResponse
     */
    public function update($id, SettingFixedCostRequest $request)
    {
        $algo = new SettingFixedCostAlgo((int) $id);

        return $algo->update($request);
    }

    /**
     * @param string $id
     *
     * @return JsonResponse
     */
    public function delete($id)
    {
        $algo = new SettingFixedCostAlgo((int) $id);

        return $algo->delete();
    }
}
