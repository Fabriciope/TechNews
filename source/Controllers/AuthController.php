<?php

namespace Source\Controllers;

class AuthController
{
    public function registerUser(array $data): void
    {
        if(csrf_verify($data)) {
            
        }
    }
}