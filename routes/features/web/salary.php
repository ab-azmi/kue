<?php
namespace App\Features\Web;

use App\Http\Controllers\Web\Salary\SalaryController;
use Illuminate\Support\Facades\Route;

Route::prefix('salaries')
    ->controller(SalaryController::class)
    ->group(function(){
        Route::get('/', 'Index');
        Route::post('/', 'Store');
        Route::get('/{id}', 'Show');
        Route::put('/{id}', 'Update');
        Route::delete('/{id}', 'Destroy');
    });