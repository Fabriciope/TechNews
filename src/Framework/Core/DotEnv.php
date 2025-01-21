<?php

namespace Src\Framework\Core;

class DotEnv
{
    private \Dotenv\Dotenv $dotEnv;

    public function __construct(string $envDirectory)
    {
        if (!is_dir($envDirectory)) {
            throw new \InvalidArgumentException('the given directory does not exist');
        }

        $this->dotEnv = \Dotenv\Dotenv::createImmutable($envDirectory);
    }

    public function loadEnvironment(): void
    {
        $this->dotEnv->load();
    }
}
