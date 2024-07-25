<?php

namespace Src\Support\Messages;

trait FlashMessages
{
    use Messages;

    protected function successFlashMessage(string $message): void
    {
        $this->successMessage($message, MessageType::SUCCESS)->flash();
    }

    protected function infoFlashMessage(string $message): void
    {
        $this->infoMessage($message, MessageType::INFO)->flash();
    }

    protected function warningFlashMessage(string $message): void
    {
        $this->warningMessage($message, MessageType::WARNING)->flash();
    }

    protected function errorFlashMessage(string $message): void
    {
        parent::errorMessage($message, MessageType::ERROR)->flash();
    }

    protected function floatSuccessFlashMessage(string $message): void
    {
        $this->floatSuccessMessage($message, MessageType::SUCCESS)->flash();
    }

    protected function floatInfoFlashMessage(string $message): void
    {
        $this->floatInfoMessage($message, MessageType::INFO)->flash();
    }

    protected function floatWarningFlashMessage(string $message): void
    {
        $this->floatWarningMessage($message, MessageType::WARNING)->flash();
    }

    protected function floatErrorFlashMessage(string $message): void
    {
        $this->floatErrorMessage($message, MessageType::ERROR)->flash();
    }
}
