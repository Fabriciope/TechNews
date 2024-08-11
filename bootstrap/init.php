<?php

use Src\Framework\Core\Template\TemplatesEngine;
use Src\Framework\Exceptions\NonExistentException;
use Src\Framework\Http\Routing\Router;

error_reporting(E_ALL);

require_once __DIR__ . "./../routes/web.php";
require_once __DIR__ . "./../routes/api.php";
require_once __DIR__ . "/AppLauncher.php";

$router = new Router();

try {
    $routeManager = $router->getRouteManager();

    // TODO: arrumar problema de agrupamento
    defineWebRoutes($routeManager);

    $routeManager->newGroup()
        ->setPrefix('api')
        ->setMiddlewares(
            Src\Framework\Http\Middleware\Middlewares\APIMiddleware::class
        )->group('defineAPIRoutes');// TODO: arrumar problema de agrupamento


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
