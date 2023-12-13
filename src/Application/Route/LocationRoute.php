<?php

use Helper\Core\Route;

$locationController = $container->resolve('LocationController');

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/location/all/user/([0-9-]*)',
    function($userId) {
        $GLOBALS['locationController']->readAllLocations($userId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/location/last/user/([0-9-]*)',
    function($userId) {
        $GLOBALS['locationController']->readLastLocation($userId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('post', '/location',
    function() {
        $GLOBALS['locationController']->createLocation();
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('delete', '/location/all/user/([0-9-]*)',
    function($userId) {
        $GLOBALS['locationController']->deleteAllLocations($userId);
    }
);

/* ------------------------------------------------------------------------------------------------- */
