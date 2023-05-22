<?php

namespace Source\Controllers;

use Source\Core\Controller;

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
        echo $this->views->render('auth-login', [
            'title' => 'Entrar'
        ]);
    }

    public function error(array $data)
    {
        var_dump($data);
    }
}
