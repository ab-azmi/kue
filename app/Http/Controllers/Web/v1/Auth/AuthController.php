<?php

namespace App\Http\Controllers\Web\v1\Auth;

use App\Algorithms\v1\Auth\AuthAlgo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(public $algo = new AuthAlgo())
    {
        
    }

    public function login(Request $request)
    {
        return $this->algo->login($request);
    }

    public function logout(Request $request)
    {
        return $this->algo->logout($request);
    }
}
