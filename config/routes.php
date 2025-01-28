<?php
return [
    '/' => [
        'controller' => Iuto\SaePhp\Controller\HomeController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/',
        'requiresArgument' => false
    ],
    '/detail' => [
        'controller' => Iuto\SaePhp\Controller\DetailController::class,
        'methods' => ['GET'],
        'redirect' => '/',
        'requiresArgument' => true
    ],
    '/login' => [
        'controller' => Iuto\SaePhp\Controller\LoginController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/',
        'requiresArgument' => false
    ],
    '/register' => [
        'controller' => Iuto\SaePhp\Controller\RegisterController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/',
        'requiresArgument' => false
    ]
];
