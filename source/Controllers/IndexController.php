<?php

namespace Source\Controllers;

use Source\Core\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../../views');
        $this->views->addFolder('includes', __DIR__ . '/../../views/includes');
    }

    public function pageHome()
    {
        echo $this->views->render('home', [
            'title' => 'TechNews'
        ]);
    }

    public function teste(array $data): void
    {
        var_dump($data);
    }

    public function pageArticles()
    {
        echo $this->views->render('articles', [
            'title' => 'Artigos'
        ]);
    }

    public function error(array $data) 
    {
        var_dump($data);
    }
}
