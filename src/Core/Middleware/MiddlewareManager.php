<?php

namespace Src\Core\Middleware;

use Src\Http\Requests\Request;

class MiddlewareManager
{
    public function __construct(
        private array $middlewares
    ) {
    }

    public function handle(Request $request): void
    {
        $iterator = $this->createIterator($request);
        $iterator();
    }

    private function createIterator(Request $request): callable
    {
        // TODO: find out another way to create a copied array
        $copiedMiddlewares = array_filter($this->middlewares, fn () => true);
        return $this->nextFunc($request, $copiedMiddlewares);
    }

    private function nextFunc(Request $request, array &$remainingMiddlewares): callable
    {
        return function () use ($request, $remainingMiddlewares) {
            $currentMiddlewareClass = array_shift($remainingMiddlewares);

            if (!isset($currentMiddlewareClass)) {
                return;
            }

            $currentMiddleware = new $currentMiddlewareClass();
            $currentMiddleware->handle(
                request: $request,
                next:  $this->nextFunc($request, $remainingMiddlewares)
            );
        };
    }
}
