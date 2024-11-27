<?php

namespace App\Http\Controllers\Web\Auth;

use App\Algorithms\Auth\AuthAlgo;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse|mixed
     */
    public function login(Request $request)
    {
        $algo = new AuthAlgo();
        return $algo->login($request);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $algo = new AuthAlgo();
        return $algo->logout($request);
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        $algo = new AuthAlgo();
        return $algo->refresh();
    }
}
