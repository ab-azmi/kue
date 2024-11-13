<?php

namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::prefix('users')
    ->namespace('User')
    ->group(function (){
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('/{id}', 'UserController@show');
        Route::put('/{id}', 'UserController@update');
        Route::delete('/{id}', 'UserController@destroy');
    });

