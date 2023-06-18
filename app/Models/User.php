<?php

namespace App\Models;

use App\Core\Database\Model;
use App\Core\Database\SupportModels;
use App\Support\MessageType;

/**
 * Modelo de usuário
 */
class User extends Model
{

    use SupportModels;

    protected static $entity = 'users';

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(
            ['id'],
            ['first_name', 'last_name', 'email', 'password']
        );
    }

    /**
     * bootstrap
     *
     * @return User
     */
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

    /**
     * checkStatus
     *
     * @return bool
     */
    public function checkStatus(): bool
    {
        if ($this->status != 'confirmed') {
            $this->message->make(MessageType::INFO, 'Ative sua conta, para usar este recurso');
            return false;
        }
        return true;
    }

    /**
     * findByEmail
     *
     * @param  string $email
     * @param  string $columns
     * @return ?User
     */
    public function findByEmail(string $email, string $columns = '*'): ?User
    {
        $user = $this->find('email = :email', "email={$email}", $columns)->fetch();

        if ($this->failed("Erro ao encontrar email {$email}")) return null;

        return $user;
    }

    /**
     * updateUser
     *
     * @param  ?array $files
     * @return bool
     */
    public function updateUser(?array $files = null): bool
    {
        $photo = null;
        $banner = null;
        if ($files) {
            ['userPhoto' => $userPhoto, 'userBanner' => $userBanner] = $files;
            if (!empty($userPhoto['name']))  $photo = $userPhoto;
            if (!empty($userBanner['name'])) $banner = $userBanner;
        }

        if (!$this->validateFields(photo: $photo, banner: $banner)) {
            return false;
        }

        $this->data = (object) filter_var_array((array)$this->data, FILTER_DEFAULT);

        $findEmail = $this->find('email = :email AND id <> :id', "email={$this->email}&id={$this->id}")->fetch();
        if ($findEmail) {
            $this->message->make(MessageType::WARNING, 'O e-mail informado já existe');
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

    /**
     * createUser
     *
     * @param  ?string $passwordConfirmation
     * @return bool
     */
    public function createUser(?string $passwordConfirmation = null): bool
    {
        if (!$this->validateFields($passwordConfirmation)) {
            return false;
        }

        $findByEmail = $this->findByEmail($this->email, 'id');
        if ($findByEmail) {
            $this->message->make(MessageType::WARNING, 'O email informado já está cadastrado');
            return false;
        }

        $userId = $this->create($this->safe());
        if ($this->failed('Erro ao cadastrar')) return false;

        $this->data = ($this->findById($userId))->data();
        return true;
    }

    /**
     * validateFields
     *
     * @param  ?string $passwordConfirmation
     * @param  ?array $photo
     * @param  ?array $banner
     * @return bool
     */
    protected function validateFields(?string $passwordConfirmation = null, ?array $photo = null, ?array $banner = null): bool
    {
        if (!$this->required()) {
            $this->message->make(MessageType::INFO, 'Preencha todos os campos requeridos');
            return false;
        }
        if (!is_email($this->email)) {
            $this->message->make(MessageType::WARNING, 'Insira um email válido');
            return false;
        }

        if ($passwordConfirmation) {
            if ($this->password != $passwordConfirmation) {
                $this->message->make(MessageType::WARNING, 'A confirmação de senhas está incorreta');
                return false;
            }
        }
        if (!is_password($this->password)) {
            $min = CONF_PASSWD_MIN_LEN;
            $max = CONF_PASSWD_MAX_LEN;
            $this->message->make(MessageType::WARNING, "Insira uma senha entre {$min} e {$max} caracteres");
            return false;
        } else {
            $this->password = generatePassword($this->password);
        }

        if ($photo) {
            if (in_array('', $photo)) {
                $this->message->make(MessageType::WARNING, 'Esta foto não pode ser carregada');
                return false;
            }
        }
        if ($banner) {
            if ($bannerImage = $banner['tmp_name']) {
                [$width, $height] = getimagesize($bannerImage);
                $minimumHeight = (50 * intval($width)) / 100;
                if ($height >= $minimumHeight) {
                    $this->message->make(MessageType::WARNING, 'Insira um banner com as recomendações desejadas');
                    return false;
                }
            } else {
                $this->message->make(MessageType::WARNING, 'Este banner não pode ser carregada');
                return false;
            }
        }

        return true;
    }
}
