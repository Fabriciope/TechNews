<?php

namespace Src\Core\Routing;

use Src\Core\Routing\Exceptions\{NonExistentControllerException, NonExistentMiddlewareException};
use Src\Exceptions\NonExistentException;
use Src\Core\Traits\ClassAndMethodChecker;
use Src\Http\HttpMethods;

class RouteManager extends RouteRecorder
{
    use ClassAndMethodChecker;

    private array $routes;

    public function __construct()
    {
        foreach(HttpMethods::cases() as $method) {
            $this->routes[$method->name] = array();
        }
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    protected function addRoute(HttpMethods $method, string $path, array|string $controllerData): Route
    {
        if(is_string($controllerData) or (count($controllerData) != 2)) {
            throw new \InvalidArgumentException("Controller and action must be passed within an array");
        }

        list($controller, $action) = $controllerData;

        $route = new Route(
            method: $method,
            path: $path,
            controllerClass: $controller,
            actionName: $action
        );

        $this->appendRoute($route);
        return $route;
    }

    /**
    * Resgister a new route
    *
    * @param \Src\Core\Routing\Route $route
    * @throws \Src\Core\Routing\Exceptions\NonExistentController
    * @throws \Src\Core\Routing\Exceptions\NonExistentAction
    */
    public function appendRoute(Route $route): void
    {
        $controller = $route->controllerClass;
        $action = $route->actionName;

        if(!$this->classExists($controller)) {
            throw new NonExistentControllerException("the {$controller} controller does not exist for the path {$route->path}", $controller);
        }

        if(!$this->methodExists($controller, $action)) {
            throw new NonExistentException("the {$action} method does not exists in {$controller} controller");
        }

        foreach($route->middlewares as $middleware) {
            if(!$this->classExists($middleware)) {
                throw new NonExistentMiddlewareException("the {$middleware} middleware does not exist", $middleware);
            }
        }

        array_push($this->routes[$route->method->name], $route);
    }


    public function newGroup(): RouteGroupManagerDecorator
    {
        return new RouteGroupManagerDecorator($this);
    }
}
