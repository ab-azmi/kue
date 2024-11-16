<?php
namespace App\Routes\Web\v1\Auth;

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->namespace('Auth')
    ->controller('AuthController')
    ->group(function () {
        Route::post('/login', 'login')->withoutMiddleware([AuthMiddleware::class]);
        Route::post('/logout', 'logout');
    });