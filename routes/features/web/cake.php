<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Cake\CakeComponentIngridientController;
use App\Http\Controllers\Web\Cake\CakeController;
use App\Http\Controllers\Web\Cake\CakeDiscountController;
use App\Http\Controllers\Web\Setting\CakeVariantController;
use Illuminate\Support\Facades\Route;

Route::prefix('cakes')
    ->group(function () {
        Route::prefix('variants')
            ->controller(CakeVariantController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
            });

        Route::prefix('discounts')
            ->controller(CakeDiscountController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
            });

        Route::prefix('ingridients')
            ->controller(CakeComponentIngridientController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
            });

        Route::controller(CakeController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
                Route::post('cogs', 'cogs');
            });
    });
