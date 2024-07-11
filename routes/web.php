<?php

use Src\Core\Routing\Router;
use Src\Http\Controllers\WebController;

$router = new Router();
$route = $router->getRouteManager();

try {
    // TODO: add path rules

    $route->get("/", [WebController::class, "home"]);
    $route->get("/{other}/article/{id}", [WebController::class, "user"]);
    $route->get("/test/user/{test}", [WebController::class, "user"]);
    $route->get("/route/artiacle/{id}", [WebController::class, "user"]);
    $route->get("/test/user/{test}/{outro}", [WebController::class, "user"]);

} catch(\Src\Exceptions\NonExistentException $exception) {
    // TODO: redirecionar para pagina de error loggar
    echo "<h1>Error: {$exception->getMessage()}</h1>";
    exit;
}
