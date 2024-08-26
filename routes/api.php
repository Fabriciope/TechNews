<?php

use Src\Http\Controllers\API\AuthController;

/**
* @var Src\Framework\Http\Routing\RouteRecorderInterface $route
*/


$route->get('/test', [AuthController::class, 'test']);
