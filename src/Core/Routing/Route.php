<?php

namespace Src\Core\Routing;

use Src\Http\HttpMethods;
use Src\Http\Middleware\MiddlewareInterface;

class Route
{
    /**
    * Registered middlewares
    *
    * @var \Http\Middleware\MiddlewareInterface[] $middlewares
    */
    private array $middlewares = array();

    public function __construct(
        private HttpMethods $method,
        private string $path,
        private string $controllerClass,
        private string $actionName,
    ) {
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function setMiddlewares(MiddlewareInterface ...$middlewares): void
    {
        foreach ($middlewares as $middleware) {
            $this->addMiddleware($middleware);
        }
    }

    private function addMiddleware(MiddlewareInterface $middleware): void
    {
        array_push($this->middlewares, $middleware);
    }

    // TODO: ver como ira ficar o array final com as rotas
    public function toArray(): array
    {
        return [];
    }
}
