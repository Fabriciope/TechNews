<?php

namespace Source\Controllers;

use Source\Core\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "./../../views/user");
    }

    public function pageProfile()
    {
        echo $this->views->render("profile-default", []);
    }
}