<?php

namespace App\Http\Controllers\Web\Setting;

use App\Algorithms\Setting\SettingAlgo;
use App\Http\Controllers\Controller;
use App\Models\Setting\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(public $algo = new SettingAlgo())
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function get(Request $request)
    {
        $algos = Setting::getOrPaginate($request, true);
        return success($algos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        return $this->algo->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function detail(string $id)
    {
        $setting = Setting::find($id);
        return success($setting);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->algo->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $this->algo->setting = Setting::find($id);
        return $this->algo->delete();
    }
}
