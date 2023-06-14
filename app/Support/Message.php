<?php

namespace App\Support;

use App\Core\Session;

class Message
{
    private readonly MessageType $type;
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
        return (string) $this->type->value;
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

    public function make( MessageType $type, string $message): Message
    {
        $this->type = $type;
        $this->message = $message;
        return $this;
    }  

    public function render(bool $fixed = false): string
    {
        if($fixed || $this->fixed) {
            $fixed = 'fixed';
        } else {
            $fixed = '';
        }
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

    public function flash(bool $fixed = false): void
    {
        $fixed ? $this->fixed= true :  $this->fixed = false;
        (new Session)->set('flashMessage', $this);
    }

    private function filter(string $text): string
    {
        return filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}