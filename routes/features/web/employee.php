<?php

use App\Http\Controllers\Web\Employee\EmployeeController;
use App\Http\Controllers\Web\Employee\EmployeeSalaryController;
use App\Http\Controllers\Web\Employee\EmployeeUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')
    ->group(function () {

        Route::prefix('users')
            ->controller(EmployeeUserController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
            });

        Route::prefix('salaries')
            ->controller(EmployeeSalaryController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
            });

        Route::controller(EmployeeController::class)
            ->group(function () {
                Route::get('/', 'get');
                Route::post('/', 'create');
                Route::get('/{id}', 'detail');
                Route::put('/{id}', 'update');
                Route::delete('/{id}', 'delete');
            });
    });
