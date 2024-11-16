<?php

namespace App\Algorithms\v1\Auth;

use App\Models\v1\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthAlgo
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
     
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $credentials['email'])->first();
                $token = Str::random(60);
                $user->update(['api_token' => $token]);

                $request->session()->regenerate();
     
                return response()->json([
                    'token' => $token,
                    'auth_type' => 'Bearer',
                ]);
            }
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);

        } catch (\Exception $e) {
            exception($e);
        }
    }
    public function register(Request $request) {}
    public function revalidate(Request $request) {}
}
