<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')
    ->controller(TransactionController::class)
    ->group(function () {
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });
