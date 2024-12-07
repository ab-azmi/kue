<?php

namespace App\Algorithms\Auth;

use App\Models\Employee\EmployeeUser;
use App\Parser\Employee\EmployeeUserParser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use GlobalXtreme\Validation\Validator;

class AuthAlgo
{
    /**
     * @return JsonResponse|void
     */
    public function login(Request $request)
    {
        try {
            Validator::make($request->all(), [
                'email' => 'required|email|exists:employee_users,email',
                'password' => 'required',
                'remember' => 'boolean',
            ]);

            $credentials = $request->only('email', 'password');

            if($request->has('remember') && $request->remember == "1") {
                Auth::factory()->rememberTokenLifetime = 60 * 24 * 30;
            }

            $token = Auth::attempt($credentials);

            if ($token) {
                $user = Auth::user();

                $request->session()->regenerate();

                return success([
                    'token' => $token,
                    'auth_type' => 'Bearer',
                    'user' => EmployeeUserParser::brief($user),
                ]);
            }

            errUnauthorized();

        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @param array $credentials
     *
     * @return JsonResponse|void|EmployeeUser
     */
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
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        try {
            Auth::logout();

            return success(
                message: 'Successfully logged out.'
            );
        } catch (\Exception $e) {
            exception($e);
        }
    }

    /**
     * @return JsonResponse
     */
    public function refresh()
    {
        try {
            $token = Auth::refresh();

            return success([
                'token' => $token,
                'auth_type' => 'Bearer',
            ]);
        } catch (\Exception $e) {
            exception($e);
        }
    }
}
