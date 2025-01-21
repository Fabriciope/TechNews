<?php

namespace Src\Framework\Core;

class Session
{
    private static ?Session $instance;

    private string $sessionName;

    private string $sessionId;

    private string $savePath;

    private const array COOKIE_PARAMS = [
        'path' => '/',
        'httponly' => true, // prevent JavaScript access to session cookie
        //'secure' => true // if you only want to receive the cookie over HTTPS
        'samesite' => 'Strict',
    ];

    private function __construct()
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            //session_save_path(__DIR__.'/../../../storage/sessions');
            session_set_cookie_params(self::COOKIE_PARAMS);
            session_start([                'name' => env('APP_NAME', 'TN') . '_SESSID',
                'use_only_cookies' => true,
                //'cookie_httponly' => true
            ]);
        }

        $this->sessionName = session_name();
        $this->sessionId = session_id();// SID
        $this->savePath = session_save_path();
    }


    public static function getInstance(): Session
    {
        if (!isset(self::$instance)) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    public function __get(string $name): mixed
    {
        if (!$this->has($name)) {
            return null;
        }

        return $_SESSION[$name];
    }

    public function __isset(string $name): bool
    {
        return $this->has($name);
    }

    public function getId(): string
    {
        return $this->sessionId;
    }

    public function getName(): string
    {
        return $this->sessionName;
    }

    public function getSavePath(): string
    {
        return $this->savePath;
    }

    public function set(string $key, mixed $value): Session
    {
        if (empty($key)) {
            throw new \InvalidArgumentException("key parameter must not be empty, given: {$key}");
        }

        $_SESSION[$key] = $value;
        return $this;
    }

    public function unset(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function unsetAll(): bool
    {
        return session_unset();
    }

    public function get(string $key, string $default = ''): mixed
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    public function getAll(): array
    {
        return $_SESSION;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        if (session_status() != PHP_SESSION_ACTIVE) {
            return;
        }

        $this->unsetAll();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                $this->getName(),
                '',
                time() - 42000,
                $params["path"],// '/'
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
        self::$instance = null;
    }

    public function regenerateId(): void
    {
        if (!session_regenerate_id(true)) {
            throw new \Exception('could not regenerate session id');
        }

        $this->sessionId = session_id();
    }
}
