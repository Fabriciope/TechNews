<?php

namespace App\Core;

/**
 * Classe responsável por manipular a Session
 */
class Session
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        if(!session_id()) {
            session_start();
        }
    }
    
    /**
     * __get
     *
     * @param  string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if(!$this->has($name)) {
            return null;
        }

        return $_SESSION[$name];
    }
    
    /**
     * __isset
     *
     * @param  string $name
     * @return bool
     */
    public function __isset($name): bool
    {
        return $this->has($name);
    }
    
    /**
     *all
     *
     * @return object
     */
    public function all(): ?object
    {
        return (object) $_SESSION;
    }
    
    /**
     * set
     *
     * @param  string $key
     * @param  string $value
     * @return Session
     */
    public function set(string $key, mixed $value): Session
    {
        $_SESSION[$key] = is_array($value) ? (object) $value : $value;
        return $this;
    }
    
    /**
     * unset
     *
     * @param  string $key
     * @return Session
     */
    public function unset(string $key): Session
    {
        if(!$this->has($key)) {
            return null;
        }

        unset($_SESSION[$key]);
        return $this;
    }
    
    /**
     * has
     *
     * @param  string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
    
    /**
     * regenerate
     *
     * @return Session
     */
    public function regenerate(): Session
    {
        session_regenerate_id();
        return $this;
    }
    
    /**
     * destroy
     *
     * @return Session
     */
    public function destroy(): Session
    {   
        session_destroy();
        return $this;
    }
    
    /**
     * getFlashMessage
     *
     * @return ?App\Support\Message
     */
    public function getFlashMessage(): ?\App\Support\Message
    {
        if($this->has('flashMessage')) {
            $flash = $this->flashMessage;
            $this->unset('flashMessage');
            return $flash;
        }
        return null;
    }
    
    /**
     * csrf
     *
     * @return void
     */
    public function csrf(): void
    {
        // $this->set('csrf_token', md5(uniqid(rand(), true)));
        $this->set('csrf_token', base64_encode(random_bytes(20)));
    }
}