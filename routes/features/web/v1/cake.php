<?php

namespace App\Routes\Features\Web\v1\Cake;

use Illuminate\Support\Facades\Route;

function CRUD()
{
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
}

Route::prefix('cakes')
    ->namespace('Cake')
    ->controller('CakeController')
    ->group(fn() => CRUD())
    ->group(function () {
        Route::get('test', fn() => 'test');
    });

Route::prefix('cakevariants')
    ->namespace('Setting')
    ->controller('CakeVariantController')
    ->group(fn() => CRUD());
