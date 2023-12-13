<?php

use Helper\Core\Route;

$cartController = $container->resolve('CartController');

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/cart/all/customer/([0-9-]*)',
    function($customerId) {
        $GLOBALS['cartController']->readCart($customerId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('get', '/cart/absent/customer/([0-9-]*)',
    function($customerId) {
        $GLOBALS['cartController']->readCartAbsentItems($customerId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('post', '/cart/product',
    function() {
        $GLOBALS['cartController']->createCartItem();
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('delete', '/cart/product/([0-9-]*)/customer/([0-9-]*)',
    function($productId, $customerId) {
        $GLOBALS['cartController']->deleteCartItem($productId, $customerId);
    }
);

/* ------------------------------------------------------------------------------------------------- */

Route::add('delete', '/cart/all/customer/([0-9-]*)',
    function($customerId) {
        $GLOBALS['cartController']->deleteCartAllItems($customerId);
    }
);

/* ------------------------------------------------------------------------------------------------- */
