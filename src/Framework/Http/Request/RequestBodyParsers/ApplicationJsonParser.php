<?php

namespace Src\Framework\Http\Request\RequestBodyParsers;

use Src\Framework\Http\Exceptions\InvalidRequestBodyException;

class ApplicationJsonParser
{
    public function __construct(
        private string $body
    ) {
    }

    public function body(): string
    {
        return $this->body;
    }

    public function toArray(): array
    {
        if (!json_validate($this->body)) {
            throw new InvalidRequestBodyException('the given json in request body is invalid');
        }

        return json_decode($this->body, associative: true);
    }
}
