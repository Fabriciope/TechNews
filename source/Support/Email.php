<?php

namespace Source\Support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailException;
use Source\Support\Message;
use stdClass;

class Email
{
    private object $data;

    private PHPMailer $phpMailer;

    private Message $message;

    public function __construct()
    {
        $this->message = new Message;

        $this->phpMailer = new PHPMailer(true);

        // CONFIG
        $this->phpMailer->isSMTP();
        $this->phpMailer->setLanguage(CONF_MAIL_OPTION_LANG);
        $this->phpMailer->isHTML(CONF_MAIL_OPTION_HTML);
        $this->phpMailer->SMTPAuth = CONF_MAIL_OPTION_SMTP_AUTH;
        $this->phpMailer->SMTPSecure = CONF_MAIL_OPTION_SECURE;
        $this->phpMailer->CharSet = CONF_MAIL_OPTION_CHARSET;

        // AUTH
        $this->phpMailer->Host = CONF_MAIL_HOST;
        $this->phpMailer->Username = CONF_MAIL_USER;
        $this->phpMailer->Password = CONF_MAIL_PASS;
        $this->phpMailer->Port = CONF_MAIL_PORT;
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
        $this->data->mailTo = $mailTo;
        $this->data->mailName = $mailName;

        return $this;
    }

    public function attach(string $fileName, string $filePath): Email
    {
        $this->data->attach[$fileName] = $filePath;
        return $this;
    }

    public function send(string $emailFrom = CONF_MAIL_SENDER['address'], string $fromName = CONF_MAIL_SENDER['name']): bool
    {
        if (empty($this->data)) {
            $this->message->error('Verifique os dados passados!');
            return false;
        }

        if(!is_email($this->data->mailTo)) {
            $this->message->error('Email de destinatário invalido!');
            return false;
        }

        if(!is_email($emailFrom)) {
            $this->message->warning('Email de remetente inválido!');
            return false;
        }

        try {

            $this->phpMailer->Subject = $this->data->subject;
            $this->phpMailer->msgHTML($this->data->body);
            $this->phpMailer->setFrom($emailFrom, $fromName);
            $this->phpMailer->addAddress($this->data->mailTo, $this->data->mailName);

            if(!empty($this->data->attach)) {
                foreach($this->data->attach as $name => $path) {
                    if (is_dir($path)) {
                        $this->phpMailer->addAttachment($path, $name);
                    }
                }
            }

            $this->phpMailer->send();

            return true;
            
        } catch(MailException $exception) {
            $this->message->error("Erro ao enviar o email, tente novamente mais tarde. ERROR: {$exception->getMessage()}");
            return false;
        }
    }
    
    public function message(): Message
    {
        return $this->message;
    }

}
