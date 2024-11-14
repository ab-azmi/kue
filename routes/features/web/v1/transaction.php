<?php

namespace App\Routes\Features\Web\v1\Transaction;

use Illuminate\Support\Facades\Route;

function CRUD()
{
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{id}', 'show');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
}

Route::prefix('transactions')
    ->namespace('Transaction')
    ->controller('TransactionController')
    ->group(fn() => CRUD())
    ->group(function () {
        Route::get('test', fn() => 'test');
    });

Route::prefix('orders')
    ->namespace('Transaction')
    ->controller('OrderController')
    ->group(fn() => CRUD());
