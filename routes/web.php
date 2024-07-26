<?php

use Src\Core\Routing\RouteRecorderInterface;
use Src\Http\Controllers\Web\SiteController;
use Src\Http\Middlewares\Authenticate;
use Src\Http\Middlewares\Guest;

function defineWebRoutes(RouteRecorderInterface $route)
{
    $route->get("/", [SiteController::class, "home"]);
    $route->post('/test', [SiteController::class, 'test']);
}
