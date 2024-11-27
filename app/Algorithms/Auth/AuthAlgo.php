<?php

namespace App\Algorithms\Auth;

use App\Models\Employee\EmployeeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GlobalXtreme\Validation\Validator;

class AuthAlgo
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'email' => 'required|email|exists:employee_users,email',
                'password' => 'required',
            ]);

            $credentials = $request->only('email', 'password');

            $token = Auth::attempt($credentials);

            if ($token) {
                $user = Auth::user();

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

    public function register($credentials) {
        try {
            Validator::make($credentials, [
                'email' => 'required|email|unique:employee_users,email',
                'password' => 'required',
                'employeeId' => 'required|exists:employees,id',
            ]);

            $user = EmployeeUser::create([
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'employeeId' => $credentials['employeeId'],
            ]);

            return $user;
        } catch (\Exception $e) {
            exception($e);
        }
    }

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
