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

    public function checkStatus(): bool
    {
        if ($this->status != 'confirmed') {
            $this->message->info('Ative sua conta, para usar este serviço');
            return false;
        }
        return true;
    }

    public function findByEmail(string $email, string $columns = '*'): ?User
    {
        $user = $this->find('email = :email', "email={$email}", $columns)->fetch();

        if ($this->failed("Erro ao encontrar email {$email}")) return null;

        return $user;
    }

    public function updateUser(?array $files = null): bool
    {
        $photo = null;
        $banner = null;
        if ($files) {
            ['userPhoto' => $userPhoto, 'userBanner' => $userBanner] = $files;

            if (!empty($userPhoto['name'])) {
                $photo = $userPhoto;
            }
            if (!empty($userBanner['name'])) {
                $banner = $userBanner;
            }
        }

        if (!$this->validateFields(photo: $photo, banner: $banner)) {
            return false;
        }

        // $this->data = (object) filter_var_array((array)$this->data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $this->data = (object) filter_var_array((array)$this->data);

        $findEmail = $this->find('email = :email AND id <> :id', "email={$this->email}&id={$this->id}")->fetch();
        if ($findEmail) {
            $this->message->warning('O e-mail informado já existe');
            return false;
        }

        if ($photo) {
            if (!$this->uploadImage(
                'photo',
                $photo,
                CONF_IMAGE_PHOTO_SIZE,
                CONF_UPLOAD_PHOTO_DIR,
                './../..'
            )) return false;
        }
        if ($banner) {
            if (!$this->uploadImage(
                'banner',
                $banner,
                CONF_IMAGE_BANNER_SIZE,
                CONF_UPLOAD_BANNER_DIR,
                './../..'
            )) return false;
        }

        $this->update(
            $this->safe(),
            'id = :id',
            "id={$this->id}"
        );
        if ($this->failed('Erro ao atualizar, verifique os dados passados')) return false;

        $this->data = ($this->findById($this->id))->data();
        return true;
    }

    public function createUser(?string $passwordConfirmation = null): bool
    {
        if (!$this->validateFields($passwordConfirmation)) {
            return false;
        }

        $findByEmail = $this->findByEmail($this->email, 'id');
        if ($findByEmail) {
            $this->message->warning('O email informado já está cadastrado');
            return false;
        }

        $userId = $this->create($this->safe());
        if ($this->failed('Erro ao cadastrar')) return false;

        $this->data = ($this->findById($userId))->data();
        return true;
    }

    private function validateFields(?string $passwordConfirmation = null, ?array $photo = null, ?array $banner = null): bool
    {
        if (!$this->required()) {
            $this->message->info('Preencha todos os campos requeridos');
            return false;
        }
        if (!is_email($this->email)) {
            $this->message->warning('Insira um email válido');
            return false;
        }

        if ($passwordConfirmation) {
            if ($this->password != $passwordConfirmation) {
                $this->message->warning('A confirmação de senhas está incorreta');
                return false;
            }
        }
        if (!is_password($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->warning("Insira uma senha entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = generatePassword($this->password);
        }

        if ($photo) {
            if (in_array('', $photo)) {
                $this->message->warning('Esta foto não pode ser carregada');
                return false;
            }
        }
        if ($banner) {
            if ($bannerImage = $banner['tmp_name']) {
                //TODO: fazer o front para exibir as recomendações desejadas;
                [$width, $height] = getimagesize($bannerImage);
                $percentage = (40 * intval($width)) / 100;
                if ($height >= $percentage) {
                    $this->message->warning('Insira um banner com as recomendações desejadas');
                    return false;
                }
            } else {
                $this->message->warning('Este banner não pode ser carregada');
                return false;
            }
        }

        return true;
    }
}
