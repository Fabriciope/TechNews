<?php

namespace Src\Framework\Http\Request;

use Src\Framework\Http\Request\RequestBodyParsers\ApplicationJsonParser;
use Src\Framework\Http\Exceptions\InvalidRouteRequestException;
use Src\Framework\Core\Session;
use Src\Framework\Http\HttpMethods;

abstract class Request
{
    private HttpMethods $method;

    private string $path;

    private array $pathParameters = [];

    private array $bodyData = [];

    private static bool $isAPIRequest;

    public function __construct()
    {
        $this->populateRequest();
    }

    public function __get($name)
    {
        // TODO: create getters
        return $this->{$name};
    }

    private function populateRequest(): void
    {
        if (self::getServerVar('REQUEST_METHOD') != 'GET') {
            $this->populateBodyData();
        }

        $this->setMethod();

        $this->path = parse_url(self::getServerVar("REQUEST_URI"), PHP_URL_PATH);

        $acceptMimes = self::getServerVar('HTTP_ACCEPT');
        self::$isAPIRequest = str_starts_with($this->path, '/api') && str_contains($acceptMimes, 'application/json');
    }

    private function populateBodyData(): void
    {
        $body = file_get_contents('php://input');
        if (empty($body)) {
            $this->bodyData = [];
        }

        $contentTypeData = [];
        $contentType = self::getServerVar('HTTP_CONTENT_TYPE', self::getServerVar('CONTENT_TYPE'));
        if (str_contains($contentType, ';')) {
            $contentTypeData = explode(';', $contentType);
            $contentType = $contentTypeData[0];
        }

        // NOTE: only post request suports multipart/form-data
        $methodName = strtoupper(self::getServerVar('REQUEST_METHOD'));
        if ($methodName === 'POST' and ($contentType === 'multipart/form-data' || $contentType === 'application/x-www-form-urlencoded')) {
            $this->bodyData = $_POST;
            return;
        }

        $data = [];

        switch ($contentType) {
            case 'application/json':
                $parser = new ApplicationJsonParser($body);
                $data = $parser->toArray();
                break;

            // TODO: apply parser for these content types

            //case 'multipart/form-data':
            //    if (!str_contains($contentType, 'boundary=')) {
            //        throw new InvalidRequestBodyException('the give form data in request body does not have a boundary attribute');
            //    }

            //    $boundary = '';

            //    foreach ($contentTypeData as $data) {
            //        if (str_contains($data, 'boundary=')) {
            //            $boundary = explode('=', $data)[1];
            //        }
            //    }

            //    $data = $this->getFormDataFromBody($body, $boundary);
            //    break;

            //case 'application/x-www-form-urlencoded':
            //    break;
            default:
                throw new InvalidRouteRequestException(
                    $this,
                    'the received body conten type is not supported'
                );
                break;
        }

        $this->bodyData = $data;
    }

    /**
     * Sets the actual request method
     *
     * @throws Src\Core\Routing\Exceptions\InvalidRouteRequestException
     */
    private function setMethod(): void
    {
        $methodName = strtoupper(self::getServerVar("REQUEST_METHOD"));
        $postMethodName = (HttpMethods::POST)->name;
        if ($methodName == $postMethodName) {
            $catchedMethod = strtoupper($this->bodyVar('_method', $postMethodName));
            if (!HttpMethods::caseExists($catchedMethod)) {
                throw new InvalidRouteRequestException(
                    $this,
                    "Invalid http method. Received method: {$catchedMethod}"
                );
            }

            unset($this->bodyData['_method']);
            $methodName = $catchedMethod;
        }

        $httpMethod = HttpMethods::{$methodName};
        $this->method = $httpMethod;
    }


    private function addPathParameter(string $key, string|int $value): void
    {
        $this->pathParameters[$key] = $value;
    }

    public function bindPathParameters(string $routePath): void
    {
        $splittedRequestPath = explode("/", trim($this->path, '/'));
        $splittedRoutePath = explode("/", trim($routePath, '/'));

        foreach ($splittedRoutePath as $subPathIndex => $subPath) {
            if ((substr($subPath, 0, 1) == "{") and (substr($subPath, -1) == "}")) {
                $this->addPathParameter(
                    key: substr($subPath, 1, -1),
                    value: $splittedRequestPath[$subPathIndex]
                );
            }
        }
    }

    public static function getSession(): Session
    {
        return Session::getInstance();
    }

    public static function getServerVar(string $varName): string|int|null
    {
        if (!isset($_SERVER[$varName])) {
            return null;
        }

        return $_SERVER[$varName];
    }

    public function getMethodName(): string
    {
        return $this->method->name;
    }

    public function pathVar(string $key, string|int $default = '', int $filter = FILTER_DEFAULT): string|int
    {
        if (array_key_exists($key, $this->pathParameters)) {
            if ($value = filter_var($this->pathParameters[$key], $filter)) {
                return $value;
            }
        }

        return $default;
    }

    public function queryString(string $key, string|int $default = '', int $filter = FILTER_DEFAULT): string|int
    {
        $value = filter_input(INPUT_GET, $key, $filter);
        if (empty($value)) {
            return $default;
        }

        return $value;
    }

    public function bodyVar(string $key, string|int $default = '', int $filter = FILTER_DEFAULT): string|int
    {
        if (!array_key_exists($key, $this->bodyData)) {
            return $default;
        }

        return filter_var($this->bodyData[$key], $filter, [
            'options' => [
                'default' => $default
            ]
        ]);
    }

    public function allInputs(): array
    {
        return array_merge();
    }

    public static function isAPIRequest(): bool
    {
        return self::$isAPIRequest;
    }
}
