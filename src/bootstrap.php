<?php

// Loading and binding all dependancies

use Helper\Core\Container;
use Helper\Core\Environment;

use Application\Repository\UserRepository;
use Application\Service\UserService;
use Application\Controller\UserController;

use Application\Repository\LocationRepository;
use Application\Service\LocationService;
use Application\Controller\LocationController;

use Application\Repository\CartRepository;
use Application\Service\CartService;
use Application\Controller\CartController;

require_once __DIR__.'/Helper/Core/Container.php';
require_once __DIR__.'/Helper/Core/Environment.php';
require_once __DIR__.'/Helper/Core/Route.php';

require_once __DIR__.'/Helper/Database/Statement.php';

require_once __DIR__.'/Helper/Request/Loader.php';
require_once __DIR__.'/Helper/Request/Validator.php';

require_once __DIR__.'/Helper/Response/Header.php';

require_once __DIR__.'/Application/Repository/UserRepository.php';
require_once __DIR__.'/Application/Service/UserService.php';
require_once __DIR__.'/Application/Controller/UserController.php';

require_once __DIR__.'/Application/Repository/LocationRepository.php';
require_once __DIR__.'/Application/Service/LocationService.php';
require_once __DIR__.'/Application/Controller/LocationController.php';

require_once __DIR__.'/Application/Repository/CartRepository.php';
require_once __DIR__.'/Application/Service/CartService.php';
require_once __DIR__.'/Application/Controller/CartController.php';

/* ------------------------------------------------------------------------------------------------- */

$env = new Environment();

$container = new Container();

// Registering PDO1 for docker container db1, database demo_1
// The .env variables also refers to db1.demo_1
$container->bind('PDO1', function() use ($env) {
    $dsn = "mysql:host={$env->get("DB_HOST")};dbname={$env->get("DB_NAME_1")};port={$env->get("DB_PORT")};";
    return new PDO($dsn, $env->get("DB_USER"), $env->get("DB_PASS"));
});

// Registering all the containers for the user repository
$container->bind('UserRepository', function ($container) {
    return new UserRepository($container->resolve('PDO1'));
});

$container->bind('UserService', function ($container) {
    return new UserService($container->resolve('UserRepository'));
});

$container->bind('UserController', function ($container) {
    return new UserController($container->resolve('UserService'));
});

/* ------------------------------------------------------------------------------------------------- */

// Registering PDO2 for docker container db1, database demo_2
// The .env variables also refers to db1.demo_2
// This is what I meant when I said I would create another
// instance of PDO to connect to the second database 
$container->bind('PDO2', function() use ($env) {
    $dsn = "mysql:host={$env->get("DB_HOST")};dbname={$env->get("DB_NAME_2")};port={$env->get("DB_PORT")};";
    return new PDO($dsn, $env->get("DB_USER"), $env->get("DB_PASS"));
});

// Registering all the containers for the locations repository
$container->bind('LocationRepository', function ($container) {
    return new LocationRepository($container->resolve('PDO2'));
});

$container->bind('LocationService', function ($container) {
    return new LocationService($container->resolve('LocationRepository'));
});

$container->bind('LocationController', function ($container) {
    return new LocationController($container->resolve('LocationService'));
});

/* ------------------------------------------------------------------------------------------------- */

// Registering PDO3 for docker container db2, database demo_3
// The .env variables also refers to db2.demo_3
// And again, there is another instance of PDO, binding it and being resolved as PDO3
$container->bind('PDO3', function() use ($env) {
    $dsn = "mysql:host={$env->get("DB_HOST_3")};dbname={$env->get("DB_NAME_3")};port={$env->get("DB_PORT_3")};";
    return new PDO($dsn, $env->get("DB_USER_3"), $env->get("DB_PASS_3"));
});

// Registering all the containers for the cart repository
$container->bind('CartRepository', function ($container) {
    return new CartRepository($container->resolve('PDO3'));
});

$container->bind('CartService', function ($container) {
    return new CartService($container->resolve('CartRepository'));
});

$container->bind('CartController', function ($container) {
    return new CartController($container->resolve('CartService'));
});

/* ------------------------------------------------------------------------------------------------- */

return $container;
