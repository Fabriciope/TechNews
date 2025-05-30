<?php

use Fabriciope\Router\Routing\RouteManager;
use Fabriciope\Router\Routing\RouteRecorderInterface as RouteRecorder;

error_reporting(E_ALL);

require_once __DIR__ . "/AppLauncher.php";

$route = new RouteManager();

try {
    require_once __DIR__ . "./../routes/web.php";

    $route->newGroup()
        ->setPrefix("api")
        ->setMiddlewares(
            Fabriciope\Router\Middleware\Middlewares\APIMiddleware::class
        )->group(function (RouteRecorder $route) {
            require_once __DIR__ . "./../routes/api.php";
        });
} catch (\Exception $exception) {
    Src\Framework\Support\Logger::critical($exception->getMessage());
    renderErrorTemplateAndExit(
        title: 'Oops!, algo deu errado',
        message: 'ocorreu um erro, mas fique tranquilo já estamos trabalhando nisso',
        code: 500
    );
}

AppLauncher::bootstrap($route);
