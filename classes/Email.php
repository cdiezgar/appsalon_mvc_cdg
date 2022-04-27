<?php

namespace Classes;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        //Cambiar en href por localhost para apuntar a local

        $from ="cuentas@appsalon.com";
        $to = $this->email;
        $aliasTo = $this->nombre;
        $asunto = "Confirma tu cuenta de AppSalon";

        $contenido = "<html>";
        $contenido .= " <p><strong>Hola " . $this->nombre . ":</strong> Has creado tu cuenta en AppSalon. Solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://glacial-coast-70005.herokuapp.com:80/confirmar-cuenta?token=".$this->token."'>Confirmar Cuenta</a> <p>"; 
        $contenido .= "<p>Si tu no has solicitado esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";
        
        $phpmailer = $this->configuracionMail($from,$to,$aliasTo,$asunto,$contenido);

        //Enviar el mail
        $phpmailer->send();
    }

    public function enviarInstrucciones() {
                //Crear el objeto de email

        $from ="cuentas@appsalon.com";
        $to = $this->email;
        $aliasTo = $this->nombre;
        $asunto = "Restablece tu password";

        $contenido = "<html>";
        $contenido .= " <p><strong>Hola " . $this->nombre . ":</strong> Has solicitado restablecer tu password. Sigue el siguiente enlace para hacerlo</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://localhost:80/recuperar?token=".$this->token."'>Restablecer Password</a> <p>";
        $contenido .= "<p>Si tu no has solicitado esta recuperacion, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";
        
        $phpmailer = $this->configuracionMail($from,$to,$aliasTo,$asunto,$contenido);

        //Enviar el mail
        $phpmailer->send();
    }

    private function configuracionMail($from,$to,$aliasTo,$asunto,$contenido) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = 'e973a49131e98b';
        $phpmailer->Password = '1d62558bc7ec91';
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = "UTF-8";
        $phpmailer->setFrom($from);
        $phpmailer->addAddress($to,$aliasTo);
        $phpmailer->Subject = $asunto;
        $phpmailer->Body = $contenido;
        return $phpmailer;
    }

}