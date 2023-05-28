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
        //carregar o user data como um objeto para carregar a página de perfil do usuário
        $user = AuthUser::user();
        if(!$user) {
            //tratar erro de outra maneira
            redirect('/entrar');
        }

        echo $this->views->render('user-profile', [
            'title' => 'Perfil',
            'userData' => $user->data()
        ]);
    }

    public function pageNewArticle(): void
    {
        $user = AuthUser::user();
        if(!$user) {
            //tratar erro de outra maneira
            redirect('/entrar');
        }

        echo $this->views->render('new-article', [
            'title' => 'Novo Artigo',
            'userData' => $user->data()
        ]);
    }

    public function pageSavedArticles(): void
    {
        $user = AuthUser::user();
        if(!$user) {
            //tratar erro de outra maneira
            redirect('/entrar');
        }

        echo $this->views->render('saved-articles', [
            'title' => 'Artigos salvos',
            'userData' => $user->data()
        ]);
    }

    public function pagePublishedArticles(): void
    {
        $user = AuthUser::user();
        if(!$user) {
            //tratar erro de outra maneira
            redirect('/entrar');
        }

        echo $this->views->render('published-articles', [
            'title' => 'Artigos publicados',
            'userData' => $user->data()
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

        if(!$user->updateProfile($_FILES)) {
            $json['fixedMessage'] = $user->message()->fixed()->render();
        } else {
            $this->message->success('Perfil atualizado com sucesso!')->fixed()->flash();
            $json['redirect'] = url('/perfil');
        }
        
        echo json_encode($json);
        return;
    }

    public function saveArticle(array $data): void
    {
        if(!csrf_verify($data)) {
            $json['fixedMessage'] = $this->message->error('Favor use o formulário')->fixed()->render();
            echo json_encode($json);
            return;
        }

        var_dump($data);
    }
}