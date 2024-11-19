<?php

use App\Http\Controllers\Web\Employee\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')
    ->group(function () {

        Route::controller(EmployeeController::class)
            ->group(function () {
                Route::get('/', 'get');
                Route::post('/', 'create');
                Route::get('/{id}', 'detail');
                Route::put('/{id}', 'update');
                Route::delete('/{id}', 'delete');
            });
    });
