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
        'redirect' => '/'
    ],
    '/restaurants' => [
        'controller' => Iuto\SaePhp\Controller\RestaurantsController::class,
        'methods' => ['GET', 'POST'],
        'redirect' => '/'
    ]
];
