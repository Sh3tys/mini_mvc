<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;

// Table des routes minimaliste
$routes = [
    ['GET', '/', [Mini\Controllers\HomeController::class, 'index']],
    ['GET', '/users', [Mini\Controllers\HomeController::class, 'users']],
    ['GET', '/contact', [Mini\Controllers\ContactController::class, 'index']],
    ['GET', '/connect/login', [Mini\Controllers\ConnectController::class, 'login']],
    ['GET', '/connect/logout', [Mini\Controllers\ConnectController::class, 'logout']],
];


// Bootstrap du routerg
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

