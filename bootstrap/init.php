<?php

use Src\Framework\Exceptions\NonExistentException;
use Src\Framework\Http\Routing\RouteManager;
use Src\Framework\Http\Routing\RouteRecorderInterface as RouteRecorder;

error_reporting(E_ALL);

require_once __DIR__ . "/AppLauncher.php";

$route = new RouteManager();

try {
    require_once __DIR__ . "./../routes/web.php";

    $route->newGroup()
        ->setPrefix("api")
        ->setMiddlewares(
            Src\Framework\Http\Middleware\Middlewares\APIMiddleware::class
        )->group(function (RouteRecorder $route) {
            require_once __DIR__ . "./../routes/api.php";
        });
} catch (NonExistentException | \InvalidArgumentException $exception) {
    renderErrorAndExit(
        title: "erro interno",
        message: "ocorreu um erro, mas fique tranquilo já estamos trabalhando nisso",
        code: 505
    );
}

AppLauncher::bootstrap($route);
