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

    protected function floatingSuccessFlashMessage(string $message): void
    {
        $this->floatingSuccessMessage($message, MessageType::SUCCESS)->flash();
    }

    protected function floatingInfoFlashMessage(string $message): void
    {
        $this->floatingInfoMessage($message, MessageType::INFO)->flash();
    }

    protected function floatingWarningFlashMessage(string $message): void
    {
        $this->floatingWarningMessage($message, MessageType::WARNING)->flash();
    }

    protected function floatingErrorFlashMessage(string $message): void
    {
        $this->floatingErrorMessage($message, MessageType::ERROR)->flash();
    }
}
