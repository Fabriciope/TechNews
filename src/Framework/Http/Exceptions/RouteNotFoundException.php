<?php

namespace Src\Framework\Http\Exceptions;

class RouteNotFoundException extends \Exception
{
    private string $path;

    public function __construct(string $path, string $message = '')
    {
        $invalidUrl = route($path);
        parent::__construct("Url inválida, url: {$invalidUrl} não encontrada");

        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
