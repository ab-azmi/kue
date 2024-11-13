<?php

namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->namespace('User')
    ->controller('UserController')
    ->group(function (){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
