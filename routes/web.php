<?php

use Src\Framework\Http\Routing\RouteRecorder;
use Src\Http\Controllers\Web\SiteController;

/**
 * @var Src\Framework\Http\Routing\RouteRecorderInterface $route
 */


$route->get('/', [SiteController::class, 'home']);


// NOTE: Errors routes
$route->newGroup()
    ->setController(Src\Http\Controllers\Web\ErrorsController::class)
    ->setPrefix('/error')
    ->group(function (RouteRecorder $route) {
        $route->get('/400', 'badRequest');
        $route->get('/404', 'notFound');
        $route->get('/500', 'internalServerError');
    });
