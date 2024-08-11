<?php

use Src\Framework\Http\Routing\RouteRecorderInterface as RouteRecorder;
use Src\Http\Controllers\API\AuthController;

// TODO: arrumar problema de agrupamento
function defineAPIRoutes(RouteRecorder $route): void
{
    $route->get('/test', [AuthController::class, 'test']);
}
