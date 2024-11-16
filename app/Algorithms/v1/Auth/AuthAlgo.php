<?php

namespace App\Algorithms\v1\Auth;

use App\Models\v1\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['token' => hash('sha256', $token)]);
                
                $request->session()->regenerate();
     
                return response()->json([
                    'token' => $token,
                    'auth_type' => 'Bearer',
                    'user' => $user->only(['id', 'name', 'email', 'role']),
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

    public function logout(Request $request) {
        try {
            $token = $request->header('Authorization');
            $token = explode(' ', $token)[1];

            $user = User::where('token', hash('sha256', $token))->first();
            DB::table('users')
                ->where('id', $user->id)
                ->update(['token' => null]);

            $request->session()->invalidate();

            return response()->json([
                'message' => 'Logged out',
            ]);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}
