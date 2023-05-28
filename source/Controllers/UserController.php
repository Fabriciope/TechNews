<?php

namespace Source\Controllers;

use Source\Core\Controller;

use Source\Models\AuthUser;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . './../../views/profile');
    }

    public function pageProfile(): void
    {
        //carregar o user data como um objeto para carregar a página de perfil do usuário
        $user = AuthUser::user();
        if(!$user) {
            //tratar erro de outra maneira
            redirect('/entrar');
        }

        echo $this->views->render('user-profile', [
            'title' => 'Perfil',
            'userData' => $user
        ]);
    }

    public function pageNewArticle(): void
    {
        echo $this->views->render('new-article', [
            'title' => 'Novo Artigo'
        ]);
    }

    public function pageSavedArticles(): void
    {
        echo $this->views->render('saved-articles', [
            'title' => 'Artigos salvos'
        ]);
    }

    public function pagePublishedArticles(): void
    {
        echo $this->views->render('published-articles', [
            'title' => 'Artigos publicados'
        ]);
    }

    public function updateProfile(array $data): void
    {
        if(!csrf_verify($data)) {
            $json['fixedMessage'] = $this->message
            ->error('Favor use o formulário!')
            ->fixed()->render();
            echo json_encode($json);
            return;
        }

        if(empty($data['firstName']) || empty($data['lastName'])) {
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

        if($user->updateProfile($_FILES)) {
            $json['redirect'] = url('/perfil');
        } else {
            $json['fixedMessage'] = $user->message()->fixed()->render();
        }
        
        echo json_encode($json);
        return;
    }
}