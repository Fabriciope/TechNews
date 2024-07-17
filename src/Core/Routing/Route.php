<?php

namespace Src\Core\Routing;

use InvalidArgumentException;
use Src\Core\Middleware\MiddlewareInterface;
use Src\Core\Routing\Exceptions\{NonExistentControllerException, NonExistentActionException, NonExistentMiddlewareException}; use Src\Core\Traits\ClassAndMethodChecker;
use Src\Http\HttpMethods;

class Route
{
    use ClassAndMethodChecker;

    /**
    * Registered middlewares
    *
    * @var Src\Core\Middleware\MiddlewareInterface[] $middlewares
    */
    private array $middlewares = array();


    /**
    * Route class constructor
    *
    * @throws Src\Core\Routing\Exceptions\NonExistentControllerException
    * @throws Src\Core\Routing\Exceptions\NonExistentActionException
    */
    public function __construct(
        private HttpMethods $method,
        private string $path,
        private string $controllerClass,
        private string $actionName,
    ) {
        $controller = $this->controllerClass;
        $action = $this->actionName;

        if(!$this->classExists($controller)) {
            throw new NonExistentControllerException($controller, "the {$controller} controller does not exist for the path {$this->path}");
        }

        if(!$this->methodExists($controller, $action)) {
            throw new NonExistentActionException($action, "the {$action} method does not exists in {$controller} controller");
        }
    }

    public function __get($name)
    {
        return $this->{$name};
    }


    /**
    * sets the route middlewares
    *
    * @param string ...$middlewares
    * @throws Src\Core\Routing\Exceptions\NonExistentMiddlewareException
    * @throws \InvalidArgumentException
    */
    public function setMiddlewares(string ...$middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $this->addMiddleware($middleware);
        }
    }

    private function addMiddleware(string $middleware): void
    {
        if(!$this->classExists($middleware)) {
            throw new NonExistentMiddlewareException($middleware, "the {$middleware} middleware does not exist");
        }

        if (!in_array(MiddlewareInterface::class, class_implements($middleware))) {
            $interfaceClass = MiddlewareInterface::class;
            throw new InvalidArgumentException("the {$middleware} middleware does not implement {$interfaceClass}");
        }

        array_push($this->middlewares, $middleware);
    }

    public function toArray(): array
    {
        return [];
    }
}
