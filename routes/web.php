<?php

use Src\Core\Routing\Router;
use Src\Core\Routing\RouteRecorder;
use Src\Core\Template\TemplatesEngine;
use Src\Exceptions\NonExistentException;
use Src\Http\Controllers\WebController;
use Src\Http\Middlewares\Authenticate;
use Src\Http\Middlewares\Guest;

$router = new Router();
$route = $router->getRouteManager();

try {
    // TODO: add path rules

    $route->get("/", [WebController::class, "home"]);

} catch(NonExistentException|\InvalidArgumentException $exception) {
    // TODO: log error ($this->getMessage())
    echo TemplatesEngine::renderErrorView(
        title: 'erro interno',
        message: 'ocorreu um erro, mas fique tranquilo já estamos trabalhando nisso',
        code: 505
    );
    exit;
}
