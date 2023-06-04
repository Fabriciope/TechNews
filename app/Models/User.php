<?php

namespace App\Models;

use App\Core\Model;

use App\Traits\ModelTrait;
use App\Support\Upload;

class User extends Model
{

    use ModelTrait;

    protected static $entity = 'users';

    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['first_name', 'last_name', 'email', 'password']
        );
    }

    public function bootstrap(
        string $firstName,
        string $lastName,
        string $email,
        string $password
    ) {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        return $this;
    }

    public function findByEmail(string $email, string $columns = '*'): ?User
    {
        $find = $this->find('email = :email', "email={$email}", $columns);
        if($this->failed("Erro ao encontrar email {$email}")) return null;

        return $find->fetch();
    }

    public function updateUser(?array $files = null): bool
    {
        if(!$this->validateFields()) {
            return false;
        }

        $this->data = (object) filter_var_array((array)$this->data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $findEmail = $this->find('email = :email AND id <> :id', "email={$this->email}&id={$this->id}")->fetch();
        if($findEmail) {
            $this->message->warning('O e-mail informado já existe');
            return false;
        }

        if($files) {

            ['userPhoto' => $photo, 'userBanner' => $banner] = $files;
    
            if(!empty($photo['name'])) { 
                if(!$this->uploadImage('photo', $photo, __DIR__ . "./../..")) return false;
            }
            
            if(!empty($banner['name'])) { 
                //TODO: refazer calculo para verificar o tamanho de forma mais precisa
                [$width, $height] = getimagesize($banner['tmp_name']);
                if($height >= $width) {
                    $this->message->warning('Insira um banner com as recomendações desejadas');
                    return false;
                }
                
                if(!$this->uploadImage('banner', $banner, __DIR__ . "./../..")) return false;
            }
        }

        $this->update(
            $this->safe(),
            'id = :id',
            "id={$this->id}"
        );
        if($this->failed('Erro ao atualizar, verifique os dados passados')) return false;

        $this->data = ($this->findById($this->id))->data();
        return true;
    }

    public function createUser(?string $passwordConfirmation = null): bool
    {   
        if(!$this->validateFields($passwordConfirmation)) {
            return false;
        }

        $findByEmail = $this->findByEmail($this->email, 'id');
        if($findByEmail) {
            $this->message->warning('O email informado já está cadastrado');
            return false;
        }

        $userId = $this->create($this->safe());
        if($this->failed('Erro ao cadastrar')) return false;

        $this->data = ($this->findById($userId))->data();
        return true;

    }

    
    // public function updateProfile(array $files): bool
    // {
    //     if(!$this->validateFields()) {
    //         return false;
    //     }

    //     ['userPhoto' => $photo, 'userBanner' => $banner] = $files;

    //     if(!empty($photo['name'])) { 
    //         if(!$this->uploadImage('photo', $photo, __DIR__ . './../..')) return false;
    //     }
        
    //     if(!empty($banner['name'])) { 
    //         //TODO: refazer calculo para verificar o tamanho de forma mais precisa
    //         [$width, $height] = getimagesize($banner['tmp_name']);
    //         if($height >= $width) {
    //             $this->message->warning('Insira um banner com as recomendações desejadas');
    //             return false;
    //         }
            
    //         if(!$this->uploadImage('banner', $banner, __DIR__ . './../..')) return false;
    //     }
        
    //     return $this->updateUser();
    // }

    private function validateFields(?string $passwordConfirmation = null): bool 
    {
        if(!$this->required()) {
            $this->message->info('Preencha todos os campos requeridos');
            return false;
        }
        if(!is_email($this->email)) {
            $this->message->warning('Insira um email válido');
            return false;
        }
        
        if($passwordConfirmation) {
            if($this->password != $passwordConfirmation) {
                $this->message->warning('A confirmação de senhas está incorreta');
                return false;
            }
        }
        if(!is_password($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("Insira uma senha entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = generatePassword($this->password);
        }
    
        //TODO: lembrar oque eu ia fazer aqui
        // if(!empty($this->photo)) {
    
        // }
    
        return true;
    }
}
