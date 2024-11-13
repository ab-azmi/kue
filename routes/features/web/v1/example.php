<?php

namespace App\Features\Web\v1;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello World!',
    ]);
});

