<?php

namespace Source\Models;

use Source\Core\Model;
use Source\Core\ViewsEngine;
use Source\Support\Email;
use Source\Core\Session;

class Auth extends Model
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

    public function register(User $user): bool
    {
        if(!$user->createUser(true)) {
            $this->message = $user->message;
            return false;
        }

        $views = (new ViewsEngine(__DIR__ . './../../shared/views/email'));
        $confirmUri = md5(uniqid(rand(), true)) . '-' . base64_encode($user->email);
        $message = $views->render('confirm', [
            'firstName' => $user->first_name,
            'confirmLink' => url('/obrigado/' . $confirmUri)
        ]);

        (new Email)->bootstrap(
        'Ative sua conta na TechNes',
            $message,
            $user->email,
            "{$user->first_name} {$user->last_name}"
        )->send();

        return true;
    }

}
