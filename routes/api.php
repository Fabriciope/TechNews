<?php

use Src\Core\Routing\RouteRecorderInterface;
use Src\Http\Controllers\API\AuthController;

function defineAPIRoutes(RouteRecorderInterface $route)
{
    $route->get('/test', [AuthController::class, 'test']);
}
