<?php

namespace Src\Http\Requests;

use Src\Http\HttpMethods;

class Request
{
    private HttpMethods $method;

    private string $uri;

    private string $path;

    private array $pathParameters;

    private string $queryStr;

    public function __construct()
    {
        $this->pupulateRequest();
    }

    private function pupulateRequest(): void
    {
        $method = strtoupper($this->getFromServerVar("REQUEST_METHOD"));
        $this->method = HttpMethods::{$method};

        $this->uri = $this->getFromServerVar("REQUEST_URI");

        $this->path = parse_url($this->uri, PHP_URL_PATH);

        $this->pathParameters = array();

        if(count($_GET) != 0) {
            $this->queryStr = parse_url($this->uri, PHP_URL_QUERY);
        } else {
            $this->queryStr = '';
        }
    }

    public function __get($name) 
    {
        return $this->{$name};
    }

    public function getFromServerVar(string $varName): string|int|null
    {
        // TODO: throw new Exception
        if (!isset($_SERVER[$varName])) {
            return null;
        }

        return $_SERVER[$varName];
    }

    public function getMethodName(): string 
    {
        return $this->method->name;
    }

    public function getFromQuery(string $key, string|int $default = '', int $filter = FILTER_DEFAULT): string|int
    {
        $value = filter_input(INPUT_GET, $key, $filter);
        if (empty($value)) {
            return $default;
        }

        return  $value;
    }

    public function addPathParameter(string $key, string|int $value): void
    {
        $this->pathParameters[$key] = $value;
    }

    public function getFromPath(string $key, string|int $default = '', int $filter = FILTER_DEFAULT): string|int
    {
        if (array_key_exists($key, $this->pathParameters)) {
            if ($value = filter_var($this->pathParameters[$key], $filter)){
                return $value;
            }
        }

        return $default;
    }

    public function getPost(string $key, string|int $default = '', int $filter = FILTER_DEFAULT): string|int
    {
        $value = filter_input(INPUT_POST, $key, $filter);
        if (empty($value)) {
            return $default;
        }

        return  $value;
    }

    public function bindPathParameters(string $routePath): void 
    {
        $splittedRequestPath = explode("/", trim($this->path, '/'));
        $splittedRoutePath = explode("/", trim($routePath, '/'));

        foreach ($splittedRoutePath as $subPathIndex => $subPath) {
            if((substr($subPath, 0, 1) == "{") and (substr($subPath, -1) == "}")) {
                $this->addPathParameter(
                    key: substr($subPath, 1, -1),
                    value: $splittedRequestPath[$subPathIndex]
                );
            }
        }
    }
}
