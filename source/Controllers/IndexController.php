<?php

namespace Source\Controllers;

use Source\Core\Controller;

use Source\Models\User;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../../views');
    }

    public function pageHome()
    {
        echo $this->views->render('home', [
            'title' => 'TechNews'
        ]);
    }

    public function pageArticlePost(array $data): void
    {
        echo $this->views->render('article-post', [
            'title' => $data['uri']
        ]);
    }

    public function pageUser(): void
    {
        echo $this->views->render('user', [
            'title' => 'Nome usuário'
        ]);
    }

    public function teste2()
    {
        $user = new User([],[]);

        $teste = $user->find()->fetch();

        var_dump($teste);
    }

    public function teste(array $data): void
    {

        var_dump($data);

        // $paragraphs =  [];
        // foreach ($data as $field => $content) {
        //     if (strpos($field, 'contentParagraph') !== false) {
        //         $explode = explode('-', $field);
        //         $paragraphs[$explode[1]] = $content;
            
        //     }
        // }
        // var_dump($paragraphs);

        // $titles =  [];
        // foreach ($data as $field => $content) {
        //     if (strpos($field, 'titleParagraph') !== false) {
        //         $explode = explode('-', $field);
        //         $titles[$explode[1]] = $content;
            
        //     }
        // }
        // var_dump($titles);
        
        
        // $separation = [];

        // foreach($paragraphs as $position => $content) {
        //     if(!empty($titles[$position])) {
        //         var_dump($content, $titles[$position]);
        //     } else {
        //         var_dump($content, $titles[$position]); 
        //     }
        // }
        

        // var_dump($data);
    }

    public function pageArticles()
    {
        echo $this->views->render('articles', [
            'title' => 'Artigos'
        ]);
    }

    public function pageLogin(): void
    {
        if(\Source\Models\AuthUser::user()) {
            redirect('/perfil');
        }
        echo $this->views->render('auth-login', [
            'title' => 'Entrar',
            'rememberEmail' => filter_input(INPUT_COOKIE, 'authEmail')
        ]);
    }

    public function pageRegister(): void
    {
        echo $this->views->render('auth-register', [
            'title' => 'Cadastrar',
        ]);
    }

    public function pageForgetPassword(): void
    {
        echo $this->views->render('auth-forget-password', [
            'title' => 'Recuperar senha'
        ]);
    }

    public function pageResetPassword(): void
    {
        echo $this->views->render('auth-reset-password', [
            'title' => 'Redefinir senha'
        ]);
    }




    public function error(array $data)
    {
        var_dump($data);
    }
}
