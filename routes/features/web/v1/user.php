<?php

namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->namespace('User')
    ->group(function (){
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
    });

