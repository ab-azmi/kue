<?php

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\JWTMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(using: function () {
        $namespace = 'App\\Http\\Controllers';

        $version = config('base.conf.version');
        $service = config('base.conf.service');

        Route::match(['get', 'post'], 'testing', "$namespace\\Controller@testing");

        Route::prefix(config('base.conf.prefix.web') . "/$version/$service")
            ->middleware(['web', 'jwt'])
            ->namespace("$namespace\\" . config('base.conf.namespace.web'))
            ->group(base_path('routes/web.php'));

        Route::prefix(config('base.conf.prefix.mobile') . "/$version/$service")
            ->middleware(['web'])
            ->namespace("$namespace\\" . config('base.conf.namespace.mobile'))
            ->group(base_path('routes/mobile.php'));

        Route::prefix(config('base.conf.prefix.mygx') . "/$version/$service")
            ->middleware(['web'])
            ->namespace("$namespace\\" . config('base.conf.namespace.mygx'))
            ->group(base_path('routes/mygx.php'));
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: ['/api/*']);
        $middleware->alias([
            'jwt' => JWTMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //handle unauthenticated
    })->withSchedule(function () {
        //
    })->create();
