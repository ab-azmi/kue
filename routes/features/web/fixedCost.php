<?php
namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Setting\FixedCostController;
use Illuminate\Support\Facades\Route;

Route::prefix('fixedcosts')
    ->controller(FixedCostController::class)
    ->group(function(){
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });