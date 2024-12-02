<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\SettingAlgo;
use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return JsonResponse|mixed
     */
    public function get(Request $request)
    {
        $settings = Setting::filter($request)->getOrPaginate($request, true);

        return success($settings, pagination: pagination($settings));
    }

    /**
     * @param  string  $id
     *
     * @return JsonResponse|mixed
     */
    public function detail($id)
    {
        $setting = Setting::find($id);
        if (! $setting) {
            errSettingGet();
        }

        return success($setting);
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function update($id, Request $request)
    {
        $algo = new SettingAlgo($id);
        return $algo->update($request);
    }
}
