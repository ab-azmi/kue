<?php
namespace App\Features\Web;

use App\Http\Controllers\Web\Salary\SalaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('salaries')
    ->controller(SalaryController::class)
    ->group(function(){
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });