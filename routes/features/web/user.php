<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\User\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->controller(UserController::class)
    ->group(function (){
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });

