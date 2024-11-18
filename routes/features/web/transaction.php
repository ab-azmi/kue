<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Transaction\OrderController;
use App\Http\Controllers\Web\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')
    ->controller(TransactionController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
        Route::get('test', fn() => 'test');
    });

Route::prefix('orders')
    ->controller(OrderController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
