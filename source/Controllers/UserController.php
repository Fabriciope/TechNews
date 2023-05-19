<?php

namespace Source\Controllers;

use Source\Core\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "./../../views/user");
    }

    public function pageProfile(): void
    {
        echo $this->views->render("user-profile", [
            "title" => "Perfil"
        ]);
    }

    public function pageNewArticle(): void
    {
        echo $this->views->render("new-article", [
            "title" => "Novo Artigo"
        ]);
    }
}