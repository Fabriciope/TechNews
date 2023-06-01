<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuthUser;
use App\Models\Article\Article;
use App\Models\Article\Paragraph;
use App\Models\Article\Category;

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
            //tratar de outra maneira
            $this->message->info('Faça o login para ter acesso à esta página')->fixed()->flash();
            redirect('/entrar');
        }
        
        
        echo $this->views->render('user-profile', [
            'title' => 'Perfil',
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

    public function pageNewArticle(): void
    {
        $user = self::authenticateUser(true);

        $categoryOptions = (new Category)->getCategories();

        echo $this->views->render('new-article', [
            'title' => 'Novo Artigo',
            'userData' => $user->data(),
            'categoryOptions' => $categoryOptions
        ]);
    }
    
    public function saveArticle(array $data): void
    {
        if(!csrf_verify($data)) {
            $json['fixedMessage'] = $this->message->error('Favor use o formulário, ou recarregue a página')->fixed()->render();
            echo json_encode($json);
            return;
        }

        $userId = AuthUser::user('id')->id;

        $article = new Article;
        $article->bootstrap(
            $userId,
            intval($data['category']),
            str_title(trim($data['title'])),
            ucfirst(trim($data['subtitle'])),
            str_slug(trim($data['title'])),
            empty(trim($data['linkVideo'])) ? null : trim($data['linkVideo'])
        );

        if($article->findByUri($article->uri)) {
            $json['fixedMessage'] = $this->message->warning('Já existe um artigo com este titulo')->fixed()->render();
            echo json_encode($json);
            return;
        }

        $titles =  array();
        $paragraphs =  array();
        foreach ($data as $field => $content) {
            if(str_contains($field, 'Paragraph')) {
                list($type, $position) = explode('-', $field);
                switch($type) {
                    case 'titleParagraph':
                        $titles[$position] = $content;
                        break;
                    case 'contentParagraph':
                        if(empty($content)) {
                            $json['fixedMessage'] = $this->message
                            ->error("Insira um conteúdo ao {$position}° parágrafo")
                            ->fixed()->render();
                            echo json_encode($json);
                            return;
                        }
                        $paragraphs[$position] = $content;
                        break;
                }
            }
        }

        if($article->createArticle($_FILES['cover'], $titles, $paragraphs)) {
            $this->message->success('Artigo criado com sucesso!')->fixed()->flash();
            $json['redirect'] = url('/perfil/artigo/salvos');
        } else {
            $json['fixedMessage'] = $article->message()->fixed()->render();
        }

        echo json_encode($json);
        return;
    }

    public function pageSavedArticles(): void
    {
        $user = self::authenticateUser(true);

        echo $this->views->render('saved-articles', [
            'title' => 'Artigos salvos',
            'userData' => $user->data(),
            'savedArticles' => (new Article)->findUserSavedArticles($user->id)
        ]);
    }

    public function publishArticle(array $data): void
    {
        $user = self::authenticateUser(true);

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if(!$articleUri|| empty($articleUri)) {
            $this->message->error('Não foi possível encontrar artigo para exclusão')->flash();
            redirect('/perfil');
            return;
        }

        $article = (new Article)->findByUri($articleUri);
        $article->status = 'published';
        $article->published_at = date_fmt_datetime('now');
        if(!$article->updateArticle()) {
            $article->message()->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }

        $this->message->success('Artigo publicado com sucesso!')->fixed()->flash();
        redirect('/perfil/artigo/salvos');
    }

    public function editArticle(array $data): void
    {
        $user = self::authenticateUser(true);

        $articleUri = filter_var($data['articleUri'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $article = (new Article)->findByUri($articleUri);
        if(empty($data['articleUri']) || !$article) {
            $this->message->error('Artigo não encontrado para edição')->fixed()->flash();
            redirect('/perfil/artigo/salvos');
            return;
        }
        if($article->id_user != $user->id) {
            $this->message->error('Você pode editar somente seus artigos')->fixed()->flash();
            redirect('/perfil/salvos');
            return;
        }


        $category = new Category;
        $articleCategory = $category->findById($article->id_category)->category;
        $categoryOptionsWithSelection =  $category->selected($articleCategory)->getCategories();

        $paragraph = new Paragraph;
        $articlesParagraphs = $paragraph->findParagraphsByArticleId($article->id);

        echo $this->views->render('new-article', [
            'title' => 'Editar ' . $article->title,
            'userData' => $user->data(),
            'articleData' => $article,
            'categoryOptions' => $categoryOptionsWithSelection,
            'articlesParagraphs' => $articlesParagraphs
        ]);
    }

    public function deleteArticle(array $data): void
    {
        var_dump($data);
    }

    public function pagePublishedArticles(): void
    {
        $user = self::authenticateUser(true);

        echo $this->views->render('published-articles', [
            'title' => 'Artigos publicados',
            'userData' => $user->data()
        ]);
    }



    private static function authenticateUser(bool $checkStatus = false): ?\App\Models\User
    {
        $user = AuthUser::user();
        if(!$user) {
            //tratar de outra maneira
            redirect('/entrar');
        }

        if($checkStatus) {
            if($user->status != 'confirmed') {
                $user->message()->info('Ative sua conta, para usar este serviço')->fixed()->flash();
                redirect('/perfil');
                return null;
            } 
        }

        return $user;
    }
}