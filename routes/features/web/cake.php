<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Cake\CakeController;
use App\Http\Controllers\Web\Cake\DiscountController;
use App\Http\Controllers\Web\Setting\CakeVariantController;
use Illuminate\Support\Facades\Route;

Route::prefix('cakes')
    ->controller(CakeController::class)
    ->group(function () {
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
        Route::post('cogs', 'cogs');
    });

Route::prefix('cakevariants')
    ->controller(CakeVariantController::class)
    ->group(function () {
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });


Route::prefix('discounts')
    ->controller(DiscountController::class)
    ->group(function () {
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });
