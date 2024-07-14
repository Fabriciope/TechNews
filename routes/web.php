<?php

use Src\Core\Routing\Router;
use Src\Core\Routing\RouteRecorder;
use Src\Http\Controllers\WebController;
use Src\Http\Middlewares\Authenticate;
use Src\Http\Middlewares\Guest;

$router = new Router();
$route = $router->getRouteManager();

try {
    // TODO: add path rules

    $route->get("/", [WebController::class, "home"])
        ->setMiddlewares(
            Authenticate::class,
            Guest::class,
        );

    $route->get("/{other}/article/{id}", [WebController::class, "user"]);
    $route->get("/test/user/{test}", [WebController::class, "user"]);
    $route->get("/route/artiacle/{id}", [WebController::class, "user"]);
    $route->get("/test/user/{test}/{outro}", [WebController::class, "user"]);

    $route->newGroup()
        ->setPrefix('test')
        ->setController(WebController::class)
        ->setMiddlewares(
            Authenticate::class,
            Guest::class
        )->group(function (RouteRecorder $route) {
            $route->get('/seila', 'user');
        });

} catch(\Src\Exceptions\NonExistentException $exception) {
    // TODO: redirecionar para pagina de error loggar
    echo "<h1>Error: {$exception->getMessage()}</h1>";
    exit;
} catch(\InvalidArgumentException $exception) {
    // TODO: redirecionar para pagina de error loggar
    echo "<h1>Error: {$exception->getMessage()}</h1>";
    exit;
}
