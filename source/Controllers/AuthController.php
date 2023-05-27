<?php

namespace Source\Controllers;

use Source\Models\AuthUser;
use Source\Core\Controller;
use Source\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . '/../../views');
    }

    public function register(array $data): void
    {
        if (AuthUser::user()) {
            redirect('/perfil');
        }
        if (!csrf_verify($data)) {
            $json['message'] = $this->message->error('Erro ao enviar, use o formulário')->render();
            echo json_encode($json);
            return;
        }
        if (in_array('', $data)) {
            $json['message'] = $this->message->info('Preencha todos os campos')->after('!')->render();
            echo json_encode($json);
            return;
        }

        $auth = new AuthUser;
        $user = (new User())->bootstrap(
            trim($data['first_name']),
            trim($data['last_name']),
            trim($data['email']),
            trim($data['password'])
        );

        if ($auth->register($user, trim($data['password_confirmation']))) {
            $json['redirect'] = url('/confirma');
        } else {
            $json['message'] = $auth->message()->before('Oops!')->after('.')->render();
        }
        echo json_encode($json);
        return;
    }

    public function pageConfirmEmail(): void
    {
        echo $this->views->render('optin', [
            'title' => 'Confirmar email',
            'data' => (object) [
                'title' => 'Falta pouco! Confirme seu cadastro',
                'desc' => 'Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro para usar nossa plataforma da melhor maneira. Caso você não tenha recebido o email, verifique se digitou o email correto.',
                'image' => theme('assets/images/confirmEmail.png'),
            ]
        ]);
    }

    public function pageConfirmedEmail(array $data): void
    {
        if (empty($data['email'])) {
            redirect('/');
        }

        $email = base64_decode($data['email']);
        $user = (new User)->findByEmail($email);

        if ($user->status != 'confirmed') {
            $user->status = 'confirmed';
            if (!$user->updateUser()) {
                //tratar o erro de outra maneira
                //recuperar o a message d0 update e renderizar como fixed
                redirect('/');
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

    public function login(array $data): void
    {

        if (!csrf_input($data)) {
            $json['message'] = $this->message->error('Favor use o formulário')->after('!')->render();
            echo json_encode($json);
            return;
        }



        if (empty($data['email']) || empty($data['password'])) {
            $json['message'] = $this->message->info('Preencha todos os campos')->after('!')->render();
            echo json_encode($json);
            return;
        }

        $minutes = 0;
        if (request_limit('login', 7, 60 * $minutes)) {
            $json['message'] = $this->message
                ->error("Você atingiu o limite de tentativas, espere {$minutes} minutos para tentar novamente")
                ->after('!')->render();

            echo json_encode($json);
            return;
        }


        $save = (!empty($data['save']) && $data['save'] == 'on') ? true : false;
        $authUser = new AuthUser;
        $login = $authUser->login($data['email'], $data['password'], $save);

        if ($login instanceof User) {
            $this->message->success("Seja bem vindo(a) {$login->first_name}")->fixed()->flash();
            $json['redirect'] = url('/perfil');
        } else {
            $json['message'] = $authUser->message()->before('Oops!')->render();
        }

        echo json_encode($json);
        return;
    }

    public function forgetPassword(array $data): void
    {
        if (!csrf_verify($data)) {
            $json['message'] = $this->message->error('Favor use o formulário')->render();
            echo json_encode($json);
            return;
        }

        if (empty($data['email'])) {
            $json['message'] = $this->message->info('Informe o e-mail')->render();
            echo json_encode($json);
            return;
        }

        if (request_repeat('email', $data['email'])) {
            $json['message'] = $this->message->info('Este e-mail já foi utilizado.')->render();
            echo json_encode($json);
            return;
        }

        $authUser = new AuthUser;
        $email = trim($data['email']);

        if ($authUser->forgetPassword($email)) {
            $json['message'] = $this->message->success('Acesse seu e-mail para recuperar a senha')->render();
        } else {
            $json['message'] = $authUser->message()->render();
        }

        echo json_encode($json);
        return;
    }

    public function pageResetPassword(array $data): void
    {
        if(empty($data)) {

            //tratar erro de outra maneira
            redirect('/recuperar-senha');
        }

        echo $this->views->render('auth-reset-password', [
            'title' => 'Redefinir senha',
            'code' => $data['code']
        ]);
    }

    public function resetPassword(array $data): void
    {
        if(in_array('', $data)) {
            $json['message'] = $this->message->info('Preencha todos os campos')->render();
            echo json_encode($json);
            return;
        }

        // [$email, $code] = explode('-', $data['code']); ou ↓
        list($email, $code) = explode('-', $data['code']);

        $authUser = new AuthUser;
        $checkPasswordRecovery = $authUser->resetPassword(
            base64_decode($email),
            $code,
            trim($data['password']),
            trim($data['passwordConfirmation'])
        );

        if($checkPasswordRecovery) {
            $this->message->success('Senha alterada com sucesso.')->flash();
            $json['redirect'] = url('/entrar');
        } else {
            $json['message'] = $authUser->message()->before('Oops!')->render();
        }
        echo json_encode($json);
        return;
    }
}
