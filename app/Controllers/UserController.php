<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuthUser;
use App\Support\Message;
use App\Support\MessageType;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(new \App\Core\ViewsEngine(__DIR__ . './../../views/profile'));
    }

    public function pageProfile(): void
    {
        $user = AuthUser::authenticateUser();
        if(!$user) {
            $this->message->make(MessageType::ERROR, 'Faça o login para ter acesso à esta página')->flash(true);
            redirect('/entrar');
        }


        echo $this->views->render('user-profile', [
            'title' => 'Perfil',
            'userData' => $user->data()
        ]);
    }

    public function updateProfile(array $data): void
    {

        if (!csrf_verify($data)) {
            $json['fixedMessage'] = $this->message
                ->make(MessageType::ERROR, 'Favor use o formulário!')
                ->render(true);
                echo json_encode($json);
            return;
        }
        
        if (empty($data['firstName']) || empty($data['lastName'])) {
            $json['fixedMessage'] = $this->message
                ->make(MessageType::INFO, 'Preencha no mínimo o nome e sobrenome')
                ->render(true);
            echo json_encode($json);
            return;
        }

        $user = AuthUser::user();
        $user->first_name = trim($data['firstName']);
        $user->last_name = trim($data['lastName']);
        $user->description = trim($data['description']);

       
        if (!$user->updateUser($_FILES)) {
            $json['fixedMessage'] = $user->message()->render(true);
        } else {
            $this->message->make( MessageType::SUCCESS, 'Perfil atualizado com sucesso!')->flash(true);
            $json['redirect'] = url('/perfil');
        }
        echo json_encode($json);
        return;
    }
}
