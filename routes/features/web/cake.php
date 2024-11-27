<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Cake\CakeComponentIngredientController;
use App\Http\Controllers\Web\Cake\CakeController;
use App\Http\Controllers\Web\Cake\CakeDiscountController;
use App\Http\Controllers\Web\Cake\CakeVariantController;
use Illuminate\Support\Facades\Route;


Route::prefix('variants')
    ->group(function () {
        Route::get('', [CakeVariantController::class, 'get']);
        Route::post('', [CakeVariantController::class, 'create']);
        Route::get('{id}', [CakeVariantController::class, 'detail']);
        Route::put('{id}', [CakeVariantController::class, 'update']);
        Route::delete('{id}', [CakeVariantController::class, 'delete']);
    });

Route::prefix('discounts')
    ->group(function () {
        Route::get('', [CakeDiscountController::class, 'get']);
        Route::post('', [CakeDiscountController::class, 'create']);
        Route::get('{id}', [CakeDiscountController::class, 'detail']);
        Route::put('{id}', [CakeDiscountController::class, 'update']);
        Route::delete('{id}', [CakeDiscountController::class, 'delete']);
    });

Route::prefix('ingredients')
    ->group(function () {
        Route::get('', [CakeComponentIngredientController::class, 'get']);
        Route::post('', [CakeComponentIngredientController::class, 'create']);
        Route::get('{id}', [CakeComponentIngredientController::class, 'detail']);
        Route::put('{id}', [CakeComponentIngredientController::class, 'update']);
        Route::delete('{id}', [CakeComponentIngredientController::class, 'delete']);
    });

Route::get('', [CakeController::class, 'get']);
Route::post('', [CakeController::class, 'create']);
Route::post('cogs', [CakeController::class, 'COGS']);
Route::get('{id}', [CakeController::class, 'detail']);
Route::put('{id}', [CakeController::class, 'update']);
Route::delete('{id}', [CakeController::class, 'delete']);
