<?php

namespace App\Algorithms\Auth;

use GlobalXtreme\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAlgo
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'email' => ['required', 'email', 'exists:employee_users,email', 'max:255'],
                'password' => ['required'],
            ]);

            $credentials = $request->only('email', 'password');

            $token = Auth::attempt($credentials);

            if ($token) {
                $user = Auth::user();

                $request->session()->regenerate();

                return success([
                    'token' => $token,
                    'auth_type' => 'Bearer',
                    'user' => $user->only(['id', 'name', 'email', 'role']),
                ]);
            }

            errUnauthenticated();

        } catch (\Exception $e) {
            exception($e);
        }
    }

    public function register(Request $request) {}

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();

            return response()->json([
                'message' => 'Logged out',
            ]);
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            $token = Auth::refresh();

            return response()->json([
                'token' => $token,
                'auth_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}
