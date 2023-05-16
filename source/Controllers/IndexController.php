<?php

namespace Source\Controllers;

use Source\Core\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../views");
    }

    public function home()
    {
        echo $this->views->render("home", [
            "title" => "TechNews"
        ]);
    }

    public function pageArticles()
    {
        echo $this->views->render("articles", [
            "title" => "Artigos"
        ]);
    }
}
