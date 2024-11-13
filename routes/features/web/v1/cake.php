<?php

namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('cakes')
    ->namespace('Cake')
    ->controller('CakeController')
    ->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });