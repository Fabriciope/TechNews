<?php

namespace Src\Support\FlashMessages;

class FlashMessage
{
    private string $text;

    private MessageType $type;

    private bool $float = false;

    private function getMessage(): string
    {
        return $this->text;
    }

    private function getType(): MessageType
    {
        return $this->type;
    }

    private function getFloatCSSClass(): string
    {
        return $this->float ? 'fixed' : '';
    }

    public function create(string $message, MessageType $type): FlashMessage
    {
        if (empty($message)) {
            throw new \InvalidArgumentException('the text message cannot be empty');
        }

        $this->text = $message;
        $this->type = $type;
        return $this;
    }

    public function float(): FlashMessage
    {
        $this->float = true;
        return $this;
    }

    public function render(): string
    {
        return <<<DIV
            <div class="message {$this->getFloatCSSClass()} {$this->getType()->value}">
                {$this->getMessage()}
            </div>
        DIV;
    }

    public function flash(): void
    {
        session()->set('flash_message', $this);
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
