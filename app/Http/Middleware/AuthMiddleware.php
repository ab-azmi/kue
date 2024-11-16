<?php

namespace App\Http\Middleware;

use App\Models\v1\User\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if(!$token){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if(strpos($token, 'Bearer ') !== 0){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $subToken = substr($token, 7);
        $user = User::where('token', hash('sha256', $subToken))->first();
      
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->merge(['user' => $user]);

        return $next($request);
    }
}
