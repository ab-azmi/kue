<?php
namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('/login', 'login')->withoutMiddleware('auth:api');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
    });