<?php

use Src\Core\Routing\RouteManager;
use Src\Core\Routing\Router;
use Src\Core\Template\TemplatesEngine;
use Src\Exceptions\NonExistentException;

error_reporting(E_ALL);

require_once __DIR__ . "./../routes/web.php";
require_once __DIR__ . "./../routes/api.php";
require_once __DIR__ . "/AppLauncher.php";

$router = new Router();

try {
    $route = $router->getRouteManager();

    defineWebRoutes($route);

    $route->newGroup()
        ->setPrefix('api')
        ->setMiddlewares(
            Src\Core\Middleware\Middlewares\APIMiddleware::class
        )->group('defineAPIRoutes');

} catch (NonExistentException|\InvalidArgumentException $exception) {
    // TODO: log error ($this->getMessage())
    echo TemplatesEngine::renderErrorView(
        title: 'erro interno',
        //message: 'ocorreu um erro, mas fique tranquilo já estamos trabalhando nisso',
        message: $exception->getMessage(),
        code: 505
    );
    exit;
}

AppLauncher::bootstrap($router);
