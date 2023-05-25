<?php

namespace Source\Models;

use Source\Core\Model;

class User extends Model
{
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
        string $password,
        string $passwordConfirmation
    ) {
        $this->first_name = $firstName;
        $this->last_name = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->password_confirmation = $passwordConfirmation;
        return $this;
    }

    public function findByEmail(string $email, string $columns = '*'): ?User
    {
        $find = $this->find('email = :email', "email={$email}", $columns);
        return $find->fetch();
    }

    public function updateUser()
    {

    }

    public function createUser(bool $create = true): bool
    {   
        if(!$this->checkFields($create)) {
            return false;
        }

        $findByEmail = $this->findByEmail($this->email, 'id');

        if($findByEmail) {
            $this->message->warning('O email informado já está cadastrado');
            return false;
        }

        $userId = $this->create($this->safe());
        if($this->fail()) {
            $this->message->error('Erro ao cadastrar.');
            return false;
        }

        $this->data = ($this->findById($userId))->data();
        return true;

    }

    public function checkFields(bool $create = false): bool 
    {
        if(!is_email($this->email)) {
            $this->message->warning('Insira um email válido')->after('!');
            return false;
        }

        if($create) {
            if($this->password != $this->password_confirmation) {
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
