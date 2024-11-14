<?php
namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('salaries')
    ->namespace('Salary')
    ->controller('SalaryController')
    ->group(function(){
        Route::get('/', 'Index');
        Route::post('/', 'Store');
        Route::get('/{id}', 'Show');
        Route::put('/{id}', 'Update');
        Route::delete('/{id}', 'Destroy');
    });