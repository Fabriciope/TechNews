<?php

namespace App\Models;

use App\Core\ViewsEngine;
use App\Support\Email;
use App\Core\Session;
use App\Support\Message;
use App\Support\MessageType;

/**
 * Model de autenticação do usuário
 */
class AuthUser
{
    private Message $message;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = new Message;
    }
    
    /**
     * message
     *
     * @return Message
     */
    public function message(): Message
    {
        return $this->message;
    }
    
    /**
     * user
     *
     * @param  string $columns
     * @return User
     */
    public static function user(string $columns = '*'): ?User
    {
        $session = new Session;
        if (!$session->has('userId')) {
            return null;
        }
        return (new User)->findById($session->userId, $columns);
    }
    
    
    /**
     * authenticateUser
     *
     * @param  bool $checkStatus
     * @param  bool $json
     * @return bool|User
     */
    public static function authenticateUser(bool $checkStatus = false, bool $json = false): bool|User
    {
        $user = self::user();
        if (!$user) {
            (new \App\Support\Message)->make(MessageType::INFO, 'você precisa estar logado em sua conta')->flash(true);
            if($json) {
                echo json_encode([
                    'redirect' => url('/entrar')
                ]);
                return false;
            }
            redirect('/entrar');
            return false;
        }

        if ($checkStatus) {
            if (!$user->checkStatus()) {
                $user->message()->flash(true);
                if($json) {
                    echo json_encode([
                        'redirect' => url('/perfil')
                    ]);
                    return false;
                }
                redirect('/perfil');
                return false;
            }
        }

        return $user;
    }
    
    /**
     * logout
     *
     * @return void
     */
    public static function logout(): void
    {
        (new Session)->unset('userId');
    }
    
    /**
     * register
     *
     * @param  User $user
     * @param  string $passwordConfirmation
     * @return bool
     */
    public function register(User $user, string $passwordConfirmation): bool
    {
        if (!$user->createUser($passwordConfirmation)) {
            $this->message = $user->message();
            return false;
        }

        $views = (new ViewsEngine(__DIR__ . './../../shared/views/email'));
        $message = $views->render('confirm', [
            'firstName' => $user->first_name,
            'confirmLink' => url('/obrigado/' . base64_encode($user->email))
        ]);

        $email = new Email;
        $email->bootstrap(
            'Ative sua conta na TechNews',
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        );
        if (!$email->send()) {
            $this->message = $email->message();
            return false;
        }

        return true;
    }
    
    /**
     * login
     *
     * @param  string $email
     * @param  string $password
     * @param  bool $save
     * @return bool
     */
    public function login(string $email, string $password, bool $save): bool|User
    {
        if (!is_email($email)) {
            $this->message->make(MessageType::WARNING, 'Insira um email válido');
            return false;
        }

        if ($save) {
            setcookie('authEmail', $email, time() + 3600, '/');
        } else {
            setcookie('authEmail', '', time() - 3600, '/');
        }

        $user = (new User)->findByEmail($email);
        if (!$user) {
            $this->message->make(MessageType::WARNING, 'O e-mail informado não está cadastrado');
            return false;
        }

        if (!passwordVerify($password, $user->password)) {
            $this->message->make(MessageType::WARNING, 'A senha informada está incorreta');
            return false;
        }

        if(password_rehash($user->password)) {
            $user->password = generatePassword($user->password);
            $user->updateUser();
        }

        (new Session)->set('userId', $user->id);
        return $user;
    }
    
    /**
     * forgetPassword
     *
     * @param  string $email
     * @return bool
     */
    public function forgetPassword(string $email): bool
    {
        if (!is_email($email)) {
            $this->message->make(MessageType::INFO, 'Insira um e-mail válido');
            return false;
        }

        $user = (new User)->findByEmail($email);
        if (!$user) {
            $this->message->make(MessageType::WARNING, 'O e-mail informado não está cadastrado');
            return false;
        }

        $user->password_recovery = md5(uniqid(rand(), true));
        if (!$user->updateUser()) {
            $this->message = $user->message();
            return false;
        }

        $views = (new ViewsEngine(__DIR__ . './../../shared/views/email'));
        $message = $views->render('forget-password', [
            'firstName' => $user->first_name,
            'forgetLink' => url('/redefinir-senha/' . base64_encode($user->email) . "-{$user->password_recovery}")
        ]);

        $email = new Email;
        $email->bootstrap(
            'Recupere sua senha no TechNews',
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        );
        if (!$email->send()) {
            $this->message = $email->message();
            return false;
        }

        return true;
    }
    
    /**
     * resetPassword
     *
     * @param  string $email
     * @param  string $code
     * @param  string $password
     * @param  string $passwordConfirmation
     * @return bool
     */
    public function resetPassword(string $email, string $code, string $password, string $passwordConfirmation): bool
    {
        $user = (new User)->findByEmail($email);
        if (!$user) {
            $this->message->make(MessageType::ERROR, 'Link inválido, usuário não encontrado');
            return false;
        }

        if ($user->password_recovery != $code) {
            $this->message->make(MessageType::ERROR, 'Erro ao autenticar a recuperação de senha, reenvie seu e-mail para recuperar');
            return false;
        }

        if ($password != $passwordConfirmation) {
            $this->message->make(MessageType::WARNING, 'A confirmação das senhas está incorreta');
            return false;
        }

        $user->password = $password;
        $user->password_recovery = null;
        if (!$user->updateUser()) {
            $this->message = $user->message();
            return false;
        }
        return true;
    }
}
