<?php

namespace Src\Support\Messages;

trait Messages
{
    protected Message $message;

    protected function successMessage(string $message): Message
    {
        return $this
            ->make($message, MessageType::SUCCESS);
    }

    protected function infoMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::INFO);
    }

    protected function warningMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::WARNING);
    }

    protected function errorMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::ERROR);
    }

    protected function floatingSuccessMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::SUCCESS)
           ->float();
    }

    protected function floatingInfoMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::INFO)
           ->float();
    }

    protected function floatingWarningMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::WARNING)
           ->float();
    }

    protected function floatingErrorMessage(string $message): Message
    {
        return $this
           ->make($message, MessageType::ERROR)
           ->float();
    }

    protected function make(string $message, MessageType $type): Message
    {
        if (!isset($this->message)) {
            $this->message = new Message();
        }

        return $this->message->create($message, $type);
    }
}
