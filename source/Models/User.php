<?php

namespace Source\Models;

use Source\Core\Model;

use Source\Traits\ModelTrait;

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
        return $find->fetch();
    }

    public function updateUser(): bool
    {
        if(!$this->checkFields()) {
            return false;
        }

        $findEmail = $this->find('email = :email AND id <> :id', "email={$this->email}&id={$this->id}")->fetch();
        if($findEmail) {
            $this->message->warning('O e-mail informado já existe');
            return false;
        }

        $this->update(
            $this->safe(),
            'id = :id',
            "id={$this->id}"
        );
        if($this->fail()) {
            $this->message->error('Erro ao atualizar, verifique os dados passados');
            return false;
        }

        $this->data = ($this->findById($this->id))->data();
        return true;
    }

    public function createUser(?string $passwordConfirmation = null): bool
    {   
        if(!$this->checkFields($passwordConfirmation)) {
            return false;
        }

        $findByEmail = $this->findByEmail($this->email, 'id');
        if($findByEmail) {
            $this->message->warning('O email informado já está cadastrado');
            return false;
        }

        $userId = $this->create($this->safe());
        if($this->fail()) {
            $this->message->error('Erro ao cadastrar');
            return false;
        }

        $this->data = ($this->findById($userId))->data();
        return true;

    }

    public function checkFields(?string $passwordConfirmation = null): bool 
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


        return true;
    }
}
