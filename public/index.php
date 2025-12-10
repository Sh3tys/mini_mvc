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

    // Routes Panier
    ['GET', '/cart', [Mini\Controllers\CartController::class, 'index']],
    ['POST', '/cart/add', [Mini\Controllers\CartController::class, 'add']],
    ['POST', '/cart/update', [Mini\Controllers\CartController::class, 'updateQuantity']],
    ['POST', '/cart/remove', [Mini\Controllers\CartController::class, 'remove']],
    ['POST', '/cart/checkout', [Mini\Controllers\CartController::class, 'checkout']],
    
    // login / register / logout
    ['GET', '/register', [Mini\Controllers\ConnectController::class, 'register']],
    ['POST', '/register', [Mini\Controllers\ConnectController::class, 'register']],
    ['GET', '/login', [Mini\Controllers\ConnectController::class, 'login']],
    ['POST', '/login', [Mini\Controllers\ConnectController::class, 'login']],
    ['GET', '/logout', [Mini\Controllers\ConnectController::class, 'logout']],
    ['POST', '/logout', [Mini\Controllers\ConnectController::class, 'logout']],
    ['GET', '/disconnect', [Mini\Controllers\ConnectController::class, 'disconnect']],
    
    //Produts Detail
    ['GET', '/detailProduct', [Mini\Controllers\ProductController::class, 'detail']],
    
    // ADMIN
    ['GET', '/users', [Mini\Controllers\HomeController::class, 'users']], 
];


// Bootstrap du routerg
$router = new Router($routes);
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

