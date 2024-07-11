<?php

use Src\Core\Routing\Router;
use Src\Http\Requests\Request;

final class AppLauncher
{
    public static function bootstrap(Router $router): void
    {
        try {
            $request = new Request();
            $router->handleRequest($request);
        } catch(Src\Core\Routing\Exceptions\InvalidRouteRequestException $exception) {
            // TODO: redirecionar para pagina de error loggar
            echo "<h1>Error: {$exception->getMessage()}</h1>";
            exit;
        }
    }
}
