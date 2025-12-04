<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;

// Table des routes minimaliste
$routes = [
    ['GET', '/', [Mini\Controllers\HomeController::class, 'acceuil']],
    ['GET', '/products', [Mini\Controllers\ProductController::class, 'index']],
    ['GET', '/about', [Mini\Controllers\ConnectController::class, 'logout']],
    ['GET', '/contact', [Mini\Controllers\ContactController::class, 'index']],
    ['GET', '/cart', [Mini\Controllers\ConnectController::class, 'logout']],
    ['GET', '/login', [Mini\Controllers\ConnectController::class, 'login']],

    ['GET', '/detailProduct', [Mini\Controllers\ConnectController::class, 'logout']],


    ['GET', '/users', [Mini\Controllers\HomeController::class, 'users']], // ADMIN
];


// Bootstrap du routerg
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

