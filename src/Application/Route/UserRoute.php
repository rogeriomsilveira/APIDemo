<?php

use Helper\Core\Route;

$userController = $container->resolve('UserController');

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/user/all',
    function() {
        $GLOBALS['userController']->readAllUsers();
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/user/([0-9-]*)',
    function($userId) {
        $GLOBALS['userController']->readUserById($userId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/user/([a-z-0-9-]*)',
    function($userName) {
        $GLOBALS['userController']->readUserByUsername($userName);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('post', '/user',
    function() {
        $GLOBALS['userController']->createUser();
    }
);

// /* ------------------------------------------------------------------------------------------------- */

Route::add('put', '/user/([0-9-]*)',
    function($userId) {
        $GLOBALS['userController']->updateUser($userId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('delete', '/user/([0-9-]*)',
    function($userId) {
        $GLOBALS['userController']->deleteUser($userId);
    }
);

/* ------------------------------------------------------------------------------------------------- */
