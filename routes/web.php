<?php

use Src\Framework\Http\Routing\RouteRecorderInterface as RouteRecorder;
use Src\Http\Controllers\Web\SiteController;
use Src\Http\Middlewares\Guest;

// TODO: arrumar problema de agrupamento
function defineWebRoutes(RouteRecorder $route): void
{
    $route->get("/", [SiteController::class, "home"])
        ->setMiddlewares(Guest::class);
    $route->get('/test', [SiteController::class, 'test']);
    $route->patch('/test/{id}/{name}', [SiteController::class, 'otherTest']);
    $route->post('/test/create', [SiteController::class, 'otherTest2']);
}
