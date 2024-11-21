<?php

namespace App\Routes\Features\Web;

use App\Http\Controllers\Web\Setting\SettingController;
use App\Http\Controllers\Web\Setting\SettingFixedCostController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')
    ->group(function () {

        Route::prefix('fixed_costs')
            ->group(function () {
                Route::get('', [SettingFixedCostController::class, 'get']);
                Route::post('', [SettingFixedCostController::class, 'create']);
                Route::get('{id}', [SettingFixedCostController::class, 'detail']);
                Route::put('{id}', [SettingFixedCostController::class, 'update']);
                Route::delete('{id}', [SettingFixedCostController::class, 'delete']);
            });


        Route::get('', [SettingController::class, 'get']);
        Route::get('{id}', [SettingController::class, 'detail']);
        Route::put('{id}', [SettingController::class, 'update']);
    });
