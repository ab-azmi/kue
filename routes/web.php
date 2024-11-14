<?php

use Illuminate\Support\Facades\Route;

$version = config('base.conf.version');
$base = base_path("routes/features/web/$version/");

require($base . "user.php");
require($base . "cake.php");
require($base . "ingridient.php");
