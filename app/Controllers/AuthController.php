<?php

namespace App\Controllers;

use App\Models\AuthUser;
use App\Core\Controller;
use App\Core\ViewsEngine;
use App\Models\User;
use App\Support\Email;
use App\Support\MessageType;

/**
 * Controller onde estão todas as rotas relacionadas a autenticação 
 */
class AuthController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(new \App\Core\ViewsEngine(__DIR__ . '/../../views'));
    }

    /**
     * > Method => POST
     * Controller responsável por fazer o registro de um usuário
     *
     * @param  array $data
     * @return void
     */
    public function register(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        if (\App\Models\AuthUser::user()) {
            echo json_encode(['redirect' => url('/perfil')]);
            return;
        }

        if (in_array('', $data)) {
            $json['message'] = $this->message->make(MessageType::INFO, 'Preencha todos os campos !')->render();
            echo json_encode($json);
            return;
        }

        $auth =  new AuthUser;
        $user = static::getModel('User')
            ->bootstrap(
                trim($data['first_name']),
                trim($data['last_name']),
                trim($data['email']),
                trim($data['password'])
            );

        if ($auth->register($user, trim($data['passwordConfirmation']))) {
            $json['redirect'] = url('/confirma');
        } else {
            $json['message'] = $auth->message()->before('Oops!')->after('.')->render();
        }
        echo json_encode($json);
        return;
    }

    /**
     * > Method => GET
     * Página de aviso da confirmação do e-mail
     *
     * @return void
     */
    public function pageConfirmEmail(): void
    {
        if ($user = AuthUser::user()) {
            $views = (new ViewsEngine(__DIR__ . './../../shared/views/email'));
            $message = $views->render('confirm', [
                'firstName' => $user->first_name,
                'confirmLink' => url('/obrigado/' . base64_encode($user->email))
            ]);

            $email = new Email;
            $email->bootstrap(
                'Ative sua conta na TechNes',
                $message,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            );
            if (!$email->send()) {
                $email->message()->make(MessageType::ERROR, 'Erro ao enviar e-mail d confirmação')->flash(true);
            }
        }

        echo $this->views->render('optin', [
            'title' => 'Confirmar email',
            'data' => (object) [
                'title' => 'Falta pouco! Confirme seu cadastro',
                'desc' => 'Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro para usar nossa plataforma da melhor maneira. Caso você não tenha recebido o email, verifique se digitou o email correto.',
                'image' => theme('assets/images/confirmEmail.png'),
            ]
        ]);
    }

    /**
     * > Method => GET
     * Página onde a conta do usuário é verificada pela confirmação do e-mail
     *
     * @param  array $data
     * @return void
     */
    public function pageConfirmedEmail(array $data): void
    {
        if (empty($data['email'])) {
            $this->message->make(MessageType::ERROR, 'Link de confirmação inválido')->flash(true);
            redirect('/');
        }

        $email = base64_decode($data['email']);
        $user = static::getModel('User')->findByEmail($email);
        if ($user->status != 'confirmed') {
            $user->status = 'confirmed';
            if (!$user->updateUser()) {
                $user->message()->before('Oops! ')->flash(true);
                back();
            }
        }

        echo $this->views->render('optin', [
            'title' => 'Email confirmado',
            'data' => (object) [
                'title' => 'Tudo pronto. Você agora podê usar o melhor que a nossa plataforma tem a ate oferecer :)',
                'desc' => 'Bem-vindo(a) ao TechNews. A melhor comunidade de tecnologia, aqui você pode publicar seus próprios artigos de tecnologia e interagir com a comunidade!',
                'image' => theme('assets/images/confirmedEmail.png'),
                'link' => url('/entrar'),
                'linkTitle' => 'Fazer Login'
            ]
        ]);
    }

    /**
     * > Method => POST
     * Controller responsável por fazer o login do usuário
     *
     * @param  mixed $data
     * @return void
     */
    public function login(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        if (empty($data['email']) || empty($data['password'])) {
            $json['message'] = $this->message->make(MessageType::INFO, 'Preencha todos os campos')->after('!')->render();
            echo json_encode($json);
            return;
        }

        $minutes = 5;
        if (request_limit('login', 7, 60 * $minutes)) {
            $json['message'] = $this->message
                ->make(MessageType::ERROR, "Você atingiu o limite de tentativas, espere {$minutes} minutos para tentar novamente")
                ->after('!')->render();
            echo json_encode($json);
            return;
        }

        $save = (!empty($data['save']) && $data['save'] == 'on') ? true : false;
        $authUser = new AuthUser;
        $login = $authUser->login($data['email'], $data['password'], $save);

        if ($login instanceof User) {
            request_limit('login', reset: true);
            $this->message->make(MessageType::SUCCESS, "Seja bem vindo(a) {$login->first_name}")->flash(true);
            $json['redirect'] = url('/perfil');
        } else {
            $json['message'] = $authUser->message()->before('Oops!')->render();
        }

        echo json_encode($json);
        return;
    }

    /**
     * > Method => POST
     * Controller responsável por receber o e-mail e enviar para a recuperação de senha
     *
     * @param  mixed $data
     * @return void
     */
    public function forgetPassword(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        if (empty($data['email'])) {
            $json['message'] = $this->message->make(MessageType::INFO, 'Informe seu e-mail para alterar a senha')->render();
            echo json_encode($json);
            return;
        }

        if (request_repeat('email', $data['email'])) {
            $json['message'] = $this->message->make(MessageType::INFO, 'Este e-mail já foi utilizado.')->render();
            echo json_encode($json);
            return;
        }

        $authUser = new AuthUser;
        $email = trim($data['email']);

        if ($authUser->forgetPassword($email)) {
            $json['message'] = $this->message->make(MessageType::SUCCESS, 'Acesse seu e-mail para alterar a senha')->render();
        } else {
            $json['message'] = $authUser->message()->render();
        }

        echo json_encode($json);
        return;
    }

    /**
     * > Method => GET
     * Página de alteração de senha
     *
     * @param  mixed $data
     * @return void
     */
    public function pageResetPassword(array $data): void
    {
        if (\App\Models\AuthUser::user()) {
            redirect('/perfil');
        }

        if (empty($data)) {
            $this->message->make(MessageType::ERROR, 'Link inválido, Informe novamente seu e-mail para recuperar a senha ou tente mais tarde')->flash();
            redirect('/recuperar-senha');
            return;
        }

        echo $this->views->render('auth-reset-password', [
            'title' => 'Redefinir senha',
            'code' => $data['code']
        ]);
    }

    /**
     * > Method => POST
     * Controller responsável por fazer a alteração da senha
     *
     * @param  mixed $data
     * @return void
     */
    public function resetPassword(array $data): void
    {
        if (!$this->checkRequest($data)) return;

        list($emailCode, $code) = explode('-', $data['code']);
        $emailReceived = base64_decode($emailCode);
        $email = is_email($emailReceived) ? $emailReceived : null;
        $code = $code ?? null;
        if (!$email || !$code) {
            $this->message->make(MessageType::ERROR, 'Link inválido, Informe novamente seu e-mail para recuperar a senha ou tente mais tarde')->flash();
            $json['redirect'] = url('/recuperar-senha');
            echo json_encode($json);
            return;
        }

        if (in_array('', $data)) {
            $json['message'] = $this->message->make(MessageType::INFO, 'Preencha todos os campos')->render();
            echo json_encode($json);
            return;
        }

        $authUser = new AuthUser;
        $resetPassword = $authUser->resetPassword(
            $email,
            $code,
            trim($data['password']),
            trim($data['passwordConfirmation'])
        );

        if ($resetPassword) {
            $this->message->make(MessageType::SUCCESS, 'Senha alterada com sucesso.')->flash();
            $json['redirect'] = url('/entrar');
        } else {
            $json['message'] = $authUser->message()->before('Oops!')->render();
        }
        echo json_encode($json);
        return;
    }

    /**
     * > Method => GET
     * Controller responsável por fazer o logout do usuário
     *
     * @return void
     */
    public function logout(): void
    {
        $this->message->make(MessageType::SUCCESS, 'Você saiu com sucesso ' . AuthUser::user()->first_name . '. Volte logo :)')->flash(true);
        AuthUser::logout();
        redirect('/entrar');
    }
}
