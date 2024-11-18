<?php
namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Ingridient\IngridientController;
use Illuminate\Support\Facades\Route;

Route::prefix('ingridients')
    ->controller(IngridientController::class)
    ->group(function(){
        Route::get('', 'index');
        Route::post('', 'store');
        Route::get('{id}', 'show');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'destroy');
    });