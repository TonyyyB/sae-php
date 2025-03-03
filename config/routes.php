<?php
return [
    '/' => [
        'controller' => Iuto\SaePhp\Controller\HomeController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/'
    ],
    '/detail' => [
        'controller' => Iuto\SaePhp\Controller\DetailController::class,
        'methods' => ['GET'],
        'redirect' => '/',
        'requiresArgument' => true
    ],
    '/restaurants' => [
        'controller' => Iuto\SaePhp\Controller\RestaurantsController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/',
        'requiresArgument' => false
    ],
    '/login' => [
        'controller' => Iuto\SaePhp\Controller\LoginController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/',
        'requiresArgument' => false
    ]
];
