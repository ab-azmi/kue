<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

Route::prefix('transactions')
    ->group(function () {
        Route::get('', [TransactionController::class, 'get']);
        Route::post('', [TransactionController::class, 'create']);
        Route::get('monthly-summary', [TransactionController::class, 'monthlySummary']);
        Route::get('{id}', [TransactionController::class, 'detail']);
        Route::delete('{id}', [TransactionController::class, 'delete']);
    });
