<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Setting\SettingFixedCostController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')
    ->group(function () {

        Route::prefix('fixed_costs')
            ->controller(SettingFixedCostController::class)
            ->group(function () {
                Route::get('', 'get');
                Route::post('', 'create');
                Route::get('{id}', 'detail');
                Route::put('{id}', 'update');
                Route::delete('{id}', 'delete');
            });
    });
