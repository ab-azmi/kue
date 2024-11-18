<?php
namespace App\Routes\Features\Web;

use Illuminate\Support\Facades\Route;

Route::prefix('ingridients')
    ->namespace('Ingridient')
    ->controller('IngridientController')
    ->group(function(){
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });