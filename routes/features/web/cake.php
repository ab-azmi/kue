<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Cake\CakeComponentIngridientController;
use App\Http\Controllers\Web\Cake\CakeController;
use App\Http\Controllers\Web\Cake\CakeDiscountController;
use App\Http\Controllers\Web\Cake\CakeVariantController;
use Illuminate\Support\Facades\Route;

Route::prefix('cakes')
    ->group(function () {
        Route::prefix('variants')
            ->group(function () {
                Route::get('', [CakeVariantController::class, 'get']);
            });

        Route::prefix('discounts')
            ->group(function () {
                Route::get('', [CakeDiscountController::class, 'get']);
                Route::post('', [CakeDiscountController::class, 'create']);
                Route::get('{id}', [CakeDiscountController::class, 'detail']);
                Route::put('{id}', [CakeDiscountController::class, 'update']);
                Route::delete('{id}', [CakeDiscountController::class, 'delete']);
            });

        Route::prefix('ingridients')
            ->group(function () {
                Route::get('', [CakeComponentIngridientController::class, 'get']);
                Route::post('', [CakeComponentIngridientController::class, 'create']);
                Route::get('{id}', [CakeComponentIngridientController::class, 'detail']);
                Route::put('{id}', [CakeComponentIngridientController::class, 'update']);
                Route::delete('{id}', [CakeComponentIngridientController::class, 'delete']);
            });


        Route::get('', [CakeController::class, 'get']);
        Route::post('', [CakeController::class, 'create']);
        Route::post('cogs', [CakeController::class, 'COGS']);
        Route::get('{id}', [CakeController::class, 'detail']);
        Route::put('{id}', [CakeController::class, 'update']);
        Route::delete('{id}', [CakeController::class, 'delete']);
    });
