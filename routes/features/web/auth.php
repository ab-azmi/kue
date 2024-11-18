<?php
namespace App\Routes\Features\Web;

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->namespace('Auth')
    ->controller('AuthController')
    ->group(function () {
        Route::post('/login', 'login')->withoutMiddleware('auth:api');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
    });