<?php

use Src\Http\Controllers\Web\SiteController;

/**
* @var Src\Framework\Http\Routing\RouteRecorderInterface $route
*/


$route->get('/', [SiteController::class, 'home']);
