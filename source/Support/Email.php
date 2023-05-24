<?php

namespace Source\Support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;
use Source\Support\Message;

class Email
{
    private object $data;

    private PHPMailer $phpMailer;

    private Message $message;

    public function __construct()
    {
        $this->phpMailer = new PHPMailer(true);

        // CONFIG
        $this->phpMailer->isSMTP();
        $this->phpMailer->setLanguage(CONF_MAIL_OPTION_LANG);
        $this->phpMailer->isHTML(CONF_MAIL_OPTION_HTML);
        $this->phpMailer->SMTPAuth = CONF_MAIL_OPTION_SMTP_AUTH;
        $this->phpMailer->SMTPSecure = CONF_MAIL_OPTION_SECURE;
        $this->phpMailer->Charset = CONF_MAIL_OPTION_CHARSET;

        // AUTH
        $this->phpMailer->Host = CONF_MAIL_HOST;
        $this->phpMailer->Username = CONF_MAIL_USER;
        $this->phpMailer->Password = CONF_MAIL_PASS;
        $this->phpMailer->PORT = CONF_MAIL_PORT;
    }

    public function bootstrap(
        string $subject,
        string $body,
        string $mailTo,
        string $mailName
    ): Email 
    {
        $this->data = new \stdClass;

        $this->data->subject = $subject;
        $this->data->body = $body;
        $this->data->$mailTo = $mailTo;
        $this->data->mailName = $mailName;

        return $this;
    }

    public function attach(string $filePath, string $fileName): Email
    {
        $this->data->attach[$filePath] = $fileName;
        return $this;
    }

    public function send(string $emailFrom = CONF_MAIL_SENDER['address'], string $fromName = CONF_MAIL_SENDER['name']): bool
    {
        if (empty($this->data)) {
            $$this->message->error('Verifique os dados passados!');
            return false;
        }

        if(is_email($this->data->mailTo)) {
            $this->message->error('Email de destinatário invalido!');
            return false;
        }

        if(is_email($emailFrom)) {
            $this->message->warning('Email de remetente inválido!');
            return false;
        }

        try {
            
        } catch(MailException $exception) {
            $this->message->error("Erro ao enviar o email, tente novamente mais tarde. ERROR: {$exception->getMessage()}");
            return false;
        }
    }
    
    public function message(): Message{
        return $this->message;
    }

}
