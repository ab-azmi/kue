<?php

use Illuminate\Support\Facades\Route;

$base = base_path("routes/features/web/");

require($base . "user.php");
require($base . "cake.php");
require($base . "ingridient.php");
require($base . "fixedCost.php");
require($base . "salary.php");
require($base . "transaction.php");
require($base . "auth.php");
