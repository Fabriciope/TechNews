<?php

namespace Source\Support;

class Message
{
    private string $type;
    private string $message;

    private string $before;
    private string $after;


    public function __toString()
    {
        $this->render();
    }

    public function getMessage(): string
    {
        return $this->message;
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
        return <<<DIV
            <div class="message {$this->type}">
                {$this->before} {$this->message} {$this->after}
            </div>
        DIV;
    }

    private function filter(string $text): string
    {
        return filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}