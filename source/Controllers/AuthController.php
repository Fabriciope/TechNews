<?php

namespace Source\Controllers;

use Source\Models\Auth;
use Source\Core\Controller;
use Source\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../../views');
    }

    public function registerUser(array $data): void
    {
        if(Auth::user()) {
            redirect('/perfil');
        }
        if(!csrf_verify($data)) {
          $json['message'] = $this->message->error('Erro ao enviar, use o formulário')->render();  
          echo json_encode($json);
          return;
        }

        if(in_array('', $data)) {
            $json['message'] = $this->message->info('Preencha todos os campos')->after('!')->render();  
            echo json_encode($json);
            return;
        }

        $auth = new Auth;
        $user = (new User())->bootstrap(
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['password'],
            $data['password_confirmation']
        );

        if($auth->register($user)) {
            $json['redirect'] = url('/confirma');
        } else {
            $json['message'] = $auth->message()->before('Oops!')->render();
        }
        echo json_encode($json);
        return;
    }

    public function confirm(): void
    {
        echo $this->views->render('optin', [
            'title' => 'confirme seu email'
        ]);
    }
}