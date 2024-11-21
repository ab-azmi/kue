<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\SettingAlgo;
use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @param SettingAlgo $algo
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $algos = Setting::getOrPaginate($request, true);
        return success($algos);
    }

    /**
     * @param string|int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $setting = Setting::find($id);

        if (!$setting) {
            errGetSetting();
        }

        return success($setting);
    }

    /**
     * @param string|int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $algo = new SettingAlgo($id);
        return $algo->update($request);
    }

}
