<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\ViewsEngine;
use Source\Support\Email;
use Source\Core\Session;

class AuthUser extends Model
{
    private static string $entity = 'users';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['first_name', 'last_name', 'email', 'password']
        );
    }

    public static function user(): ?User
    {
        $session = new Session;
        if(!$session->has('userId')) {
            return null;
        }
        return (new User)->findById($session->userId);
    }

    public function register(User $user, string $passwordConfirmation): bool
    {
        if(!$user->createUser($passwordConfirmation)) {
            $this->message = $user->message;
            return false;
        }

        $views = (new ViewsEngine(__DIR__ . './../../shared/views/email'));
        $message = $views->render('confirm', [
            'firstName' => $user->first_name,
            'confirmLink' => url('/obrigado/' . base64_encode($user->email))
        ]);

        $email = new Email;
        $email->bootstrap(
            'Ative sua conta na TechNes',
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        );

        if(!$email->send()) {
            $this->message = $email->message();
            return false;
        }

        return true;
    }

    public function login(string $email, string $password, bool $save): bool|User
    {
        if(!is_email($email)) {
            $this->message->warning('Insira um email válido');
            return false;
        }

        if($save) {
            setcookie('authEmail', $email, time() + 3600, '/');
        } else {
            setcookie('authEmail', '', time() - 3600, '/');
        }

        if(!is_password($password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("Insira uma senha entre {$min} e {$max} caracteres");
            return false;
        }

        $user = (new User)->findByEmail($email);
        if(!$user) {
            $this->message->warning('O e-mail informado não está cadastrado');
            return false;
        }
        
        if(!passwordVerify($password, $user->password)) {
            $this->message->warning('A senha informada está incorreta');
            return false;
        }
        
        (new Session)->set('authUser', $user->id);
        return $user;
    }

}
