<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\SettingAlgo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\EmployeeRequest;
use App\Models\Setting\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $settings = Setting::getOrPaginate($request, true);
        return success($settings);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detail($id)
    {
        $setting = Setting::find($id);
        if (!$setting) {
            errSettingGet();
        }

        return success($setting);
    }

    /**
     * @param  $id
     * @param EmployeeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, EmployeeRequest $request)
    {
        $algo = new SettingAlgo($id);

        return $algo->update($request);
    }
}
