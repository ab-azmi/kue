<?php

use App\Http\Controllers\Web\Employee\EmployeeController;
use App\Http\Controllers\Web\Employee\EmployeeSalaryController;
use App\Http\Controllers\Web\Employee\EmployeeUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')
    ->group(function () {

        Route::prefix('users')
            ->group(function () {
                Route::get('', [EmployeeUserController::class, 'get']);
                Route::post('', [EmployeeUserController::class, 'create']);
                Route::get('{id}', [EmployeeUserController::class, 'detail']);
                Route::put('{id}', [EmployeeUserController::class, 'update']);
                Route::delete('{id}', [EmployeeUserController::class, 'delete']);
            });

        Route::prefix('salaries')
            ->group(function () {
                Route::get('', [EmployeeSalaryController::class, 'get']);
                Route::post('', [EmployeeSalaryController::class, 'create']);
                Route::get('{id}', [EmployeeSalaryController::class, 'detail']);
                Route::put('{id}', [EmployeeSalaryController::class, 'update']);
                Route::delete('{id}', [EmployeeSalaryController::class, 'delete']);
            });


        Route::get('/', [EmployeeController::class, 'get']);
        Route::post('/', [EmployeeController::class, 'create']);
        Route::get('/{id}', [EmployeeController::class, 'detail']);
        Route::put('/{id}', [EmployeeController::class, 'update']);
        Route::delete('/{id}', [EmployeeController::class, 'delete']);
    });
