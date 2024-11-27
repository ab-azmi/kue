<?php

namespace App\Http\Controllers\Web\Auth;

use App\Algorithms\Auth\AuthAlgo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $algo = new AuthAlgo();
        return $algo->login($request);
    }

    public function logout(Request $request)
    {
        $algo = new AuthAlgo();
        return $algo->logout($request);
    }

    public function refresh()
    {
        $algo = new AuthAlgo();
        return $algo->refresh();
    }
}
