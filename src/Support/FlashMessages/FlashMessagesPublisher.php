<?php

namespace Src\Support\FlashMessages;

interface FlashMessagesPublisher
{
    public function successMessage(string $message): void;

    public function infoMessage(string $message): void;

    public function warningMessage(string $message): void;

    public function errorMessage(string $message): void;


    public function floatSuccessMessage(string $message): void;

    public function floatInfoMessage(string $message): void;

    public function floatWarningMessage(string $message): void;

    public function floatErrorMessage(string $message): void;
}
