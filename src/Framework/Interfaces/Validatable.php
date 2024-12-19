<?php

namespace Src\Framework\Interfaces;

interface Validatable
{
    /**
    * Validate something
    *
    * @throws \Exception
    */
    public function validate(): void;
}
