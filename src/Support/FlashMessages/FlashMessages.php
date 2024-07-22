<?php

namespace Src\Support\FlashMessages;

trait FlashMessages
{
    protected FlashMessage $flashMessage;

    public function success(string $message): void
    {
        $this->flashMessage
            ->create($message, MessageType::SUCCESS)
            ->flash();
    }

    public function info(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::INFO)
           ->flash();
    }

    public function warning(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::WARNING)
           ->flash();
    }

    public function error(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::ERROR)
           ->flash();
    }


    public function floatSuccess(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::SUCCESS)
           ->float()
           ->flash();
    }

    public function floatInfo(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::INFO)
           ->float()
           ->flash();
    }

    public function floatWarning(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::WARNING)
           ->float()
           ->flash();
    }

    public function floatError(string $message): void
    {
        $this->flashMessage
           ->create($message, MessageType::ERROR)
           ->float()
           ->flash();
    }
}
