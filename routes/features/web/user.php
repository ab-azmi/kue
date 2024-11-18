<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function (){
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });

