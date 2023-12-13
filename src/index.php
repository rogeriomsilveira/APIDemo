<?php

use Helper\Core\Route;
use Helper\Core\Environment;

require_once __DIR__.'/bootstrap.php';

$container = require __DIR__.'/bootstrap.php';

/* ================================================================================================= */

require_once __DIR__.'/Application/Route/UserRoute.php';
require_once __DIR__.'/Application/Route/LocationRoute.php';
require_once __DIR__.'/Application/Route/CartRoute.php';

/* ================================================================================================= */

$env = new Environment();
Route::run($env->get("BASEPATH"));
