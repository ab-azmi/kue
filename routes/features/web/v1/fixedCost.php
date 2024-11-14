<?php
namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('fixedcosts')
    ->namespace('Setting')
    ->controller('FixedCostController')
    ->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });