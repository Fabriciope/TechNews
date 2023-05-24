<?php

namespace Source\Core;

class Session
{
    public function __construct()
    {
        if(!session_id()) {
            session_start();
        }
    }

    public function __get($name)
    {
        if(!$this->has($name)) {
            return null;
        }

        return $_SESSION[$name];
    }

    public function __isset($name)
    {
        return $this->has($name);
    }

    public function all(): ?object
    {
        return (object) $_SESSION;
    }

    public function set(string $key, mixed $value): ?Session
    {
        $_SESSION[$key] = is_array($value) ? (object) $value : $value;
        return $this;
    }

    public function unset(string $key): ?Session
    {
        if(!$this->has($key)) {
            return null;
        }

        unset($_SESSION[$key]);
        return $this;
    }

    public function  has(string $key) 
    {
        return isset($_SESSION[$key]);
    }

    public function regenerate(): Session
    {
        session_regenerate_id();
        return $this;
    }

    public function destroy(): Session
    {   
        session_destroy();
        return $this;
    }

    public function getFlashMessage(): ?Source\Support\Message
    {
        if($this->has('flash')) {
            $flash = $this->flash;
            $this->unset('flash');
            return $flash;
        }
        return null;
    }

    public function csrf(): void
    {
        // $this->set('csrf_token', md5(uniqid(rand(), true)));
        $this->set('csrf_token', base64_encode(random_bytes(20)));
    }
}