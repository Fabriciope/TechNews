<?php

use Src\Framework\Http\Routing\RouteRecorder;
use Src\Http\Controllers\API\AuthController;

function defineAPIRoutes(RouteRecorder $route): void
{
    $route->get('/test', [AuthController::class, 'test']);
}
