<?php
namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Cake\CakeComponentIngridientController;
use Illuminate\Support\Facades\Route;

Route::prefix('ingridients')
    ->controller(CakeComponentIngridientController::class)
    ->group(function(){
        Route::get('', 'get');
        Route::post('', 'create');
        Route::get('{id}', 'detail');
        Route::put('{id}', 'update');
        Route::delete('{id}', 'delete');
    });