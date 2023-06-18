<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AuthUser;
use App\Support\Paginator;
use App\Support\MessageType;

/**
 * Controller onde estão todas as rotas relacionadas ao usuário
 */
class UserController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new \App\Core\ViewsEngine(__DIR__ . './../../views/profile'));
    }

    /**
     * > Method => GET
     * Página de perfil do usuário
     *
     * @return void
     */
    public function pageProfile(): void
    {
        $user = AuthUser::authenticateUser();

        echo $this->views->render('user-profile', [
            'title' => 'Perfil',
            'userData' => $user->data()
        ]);
    }

    /**
     * > Method => POST
     * Controller responsável por fazer a edição do perfil do usuário
     *
     * @param  array $data
     * @return void
     */
    public function updateProfile(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        $user = AuthUser::authenticateUser(json: true);
        if (!$user) return;

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
            $this->message->make(MessageType::SUCCESS, 'Perfil atualizado com sucesso!')->flash(true);
            $json['redirect'] = url('/perfil');
        }
        echo json_encode($json);
        return;
    }

    /**
     * > Method => GET
     * Página dos artigos publicados pelo usuário
     *
     * @param  array $data
     * @return void
     */
    public function pagePublishedArticles(array $data): void
    {
        $user = AuthUser::authenticateUser(true);

        $findArticles = static::getModel('Article')
            ->find(
                'id_user = :userId AND status = :status',
                "userId={$user->id}&status=published"
            );

        $paginator =  new Paginator(
            6,
            isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1,
            "/perfil/artigo/publicados/",
            $findArticles->count()
        );

        echo $this->views->render('published-articles', [
            'title' => 'Artigos publicados',
            'userData' => $user->data(),
            'publishedArticles' => $findArticles
                ->order('published_at', 'DESC')
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true),
            'paginator' => $paginator
        ]);
    }

    /**
     * > Method => GET
     * Página dos artigos salvos pelo usuário
     *
     * @param  array $data
     * @return void
     */
    public function pageSavedArticles(array $data): void
    {
        $user = AuthUser::authenticateUser(true);

        $findArticles = static::getModel('Article')
            ->find(
                'id_user = :userId AND status = :status',
                "userId={$user->id}&status=created"
            );

        $paginator = new Paginator(
            6,
            isset($data['page']) ? filter_var($data['page'], FILTER_VALIDATE_INT) : 1,
            "/perfil/artigos/salvos/",
            $findArticles->count()
        );

        echo $this->views->render('saved-articles', [
            'title' => 'Artigos salvos',
            'userData' => $user->data(),
            'savedArticles' => $findArticles
                ->order('created_at', 'DESC')
                ->limit($paginator->limit())
                ->offset($paginator->offset())
                ->fetch(true),
            'paginator' => $paginator
        ]);
    }
}
