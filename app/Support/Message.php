<?php

namespace App\Support;

use App\Core\Session;

/**
 * Classe responsável por gerenciar as mensagens interativas com o usuário
 */
class Message
{
    private readonly MessageType $type;
    private string $message;
    private bool $fixed = false;

    private ?string $before = null;
    private ?string $after = null;

    
    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
    
    /**
     * getType
     *
     * @return string
     */
    private function getType(): string
    {
        return (string) $this->type->value;
    }
    
    /**
     * getMessage
     *
     * @return string
     */
    private function getMessage(): string
    {
        return "{$this->before} {$this->message} {$this->after}";
    }
    
    /**
     * before
     *
     * @param  string $textBefore
     * @return Message
     */
    public function before(string $textBefore): Message
    {
        $this->before = self::filter($textBefore);
        return $this;
    }
    
    /**
     * after
     *
     * @param  string $textAfter
     * @return Message
     */
    public function after(string $textAfter): Message
    {
        $this->after = self::filter($textAfter);
        return $this;
    }
    
    /**
     * make
     *
     * @param  MessageType $type
     * @param  string $message
     * @return Message
     */
    public function make( MessageType $type, string $message): Message
    {
        $this->type = $type;
        $this->message = $message;
        return $this;
    }  
    
    /**
     * render
     *
     * @param  bool $fixed
     * @return string
     */
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
    
    /**
     * fixed
     *
     * @return Message
     */
    public function fixed(): Message
    {
        $this->fixed = true;
        return $this;
    }
    
    /**
     * flash
     *
     * @param  bool $fixed
     * @return void
     */
    public function flash(bool $fixed = false): void
    {
        $fixed ? $this->fixed= true :  $this->fixed = false;
        (new Session)->set('flashMessage', $this);
    }
    
    /**
     * filter
     *
     * @param  string $text
     * @return string
     */
    private function filter(string $text): string
    {
        return filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS);
    }
}