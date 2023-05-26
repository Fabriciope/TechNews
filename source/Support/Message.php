<?php

namespace Source\Support;

use Source\Core\Session;

class Message
{
    private string $type;
    private string $message;
    private bool $fixed = false;

    private ?string $before = null;
    private ?string $after = null;


    public function __toString()
    {
        return $this->render();
    }

    private function getType(): string
    {
        return $this->type;
    }

    private function getMessage(): string
    {
        return "{$this->before} {$this->message} {$this->after}";
    }

    public function before(string $textBefore): Message
    {
        $this->before = self::filter($textBefore);
        return $this;
    }

    public function after(string $textAfter): Message
    {
        $this->after = self::filter($textAfter);
        return $this;
    }

    public function success(string $message): Message
    {
        $this->type = 'success';
        $this->message = self::filter($message);
        return $this;
    }

    public function info(string $message): Message
    {
        $this->type = 'info';
        $this->message = self::filter($message);
        return $this;
    }

    public function warning(string $message): Message
    {
        $this->type = 'warning';
        $this->message = self::filter($message);
        return $this;
    }

    public function error(string $message): Message
    {
        $this->type = 'error';
        $this->message = $this->filter($message);
        return $this;
    }

    public function render(): string
    {
        $fixed = $this->fixed ? 'fixed' : '';
        return <<<DIV
            <div class="message {$fixed} {$this->getType()}">
                {$this->getMessage()}
            </div>
        DIV;
    }

    public function fixed(): Message
    {
        $this->fixed = true;
        return $this;
    }

    public function flash(): void
    {
        (new Session)->set('flashMessage', $this);
    }

    private function filter(string $text): string
    {
        return filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}