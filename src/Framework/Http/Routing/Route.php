<?php

namespace Src\Framework\Http\Routing;

use InvalidArgumentException;
use Src\Framework\Http\Middleware\MiddlewareInterface;
use Src\Framework\Http\Exceptions\{NonExistentControllerException, NonExistentActionException, NonExistentMiddlewareException};
use Src\Framework\Traits\ClassAndMethodChecker;
use Src\Framework\Http\HttpMethods;

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
    public function __construct( // TODO: add getters and setters to these attributes
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
    public function setMiddlewares(string ...$middlewares): Route
    {
        foreach ($middlewares as $middleware) {
            $this->addMiddleware($middleware);
        }

        return $this;
    }

    private function addMiddleware(string $middleware): void
    {
        if (in_array($middleware, $this->middlewares)) {
            throw new \InvalidArgumentException("the {$middleware} already exists");
        }

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
