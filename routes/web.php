<?php

use Src\Framework\Http\Routing\RouteRecorder;
use Src\Http\Controllers\Web\SiteController;
use Src\Http\Middlewares\Guest;

function defineWebRoutes(RouteRecorder $route): void
{
    $route->get('/', [SiteController::class, 'home']);
}
