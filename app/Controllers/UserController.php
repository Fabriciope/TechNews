<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuthUser;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . './../../views/profile');
    }

    public function pageProfile(): void
    {
        $user = AuthUser::authenticateUser();
        if(!$user) {
            $this->message->error('Faça o login para ter acesso à esta página')->fixed()->flash();
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
                ->error('Favor use o formulário!')
                ->fixed()->render();
                echo json_encode($json);
            return;
        }
        
        if (empty($data['firstName']) || empty($data['lastName'])) {
            $json['fixedMessage'] = $this->message
                ->info('Preencha no mínimo o nome e sobrenome')
                ->fixed()->render();
            echo json_encode($json);
            return;
        }

        $user = AuthUser::user();
        $user->first_name = trim($data['firstName']);
        $user->last_name = trim($data['lastName']);
        $user->description = trim($data['description']);

       
        if (!$user->updateUser($_FILES)) {
            $json['fixedMessage'] = $user->message()->fixed()->render();
        } else {
            $this->message->success('Perfil atualizado com sucesso!')->fixed()->flash();
            $json['redirect'] = url('/perfil');
        }
        echo json_encode($json);
        return;
    }

    //TODO: fazer a página do usuário
    public function pageUser(): void {}
}
