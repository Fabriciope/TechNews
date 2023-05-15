<?php

namespace Source\Controllers;

use Source\Core\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../views");
        $this->views->addFolder("layouts", __DIR__ . "/../../views/layouts");
    }
    public function home()
    {
        echo $this->views->render("home", []);
    }
}