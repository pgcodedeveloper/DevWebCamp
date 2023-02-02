<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;


class Email
{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviar()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Username = 'uptaskproyectos@gmail.com';
        $mail->Password = 'hswtlbgdhquhcslc';

        $mail->setFrom('uptaskproyectos@gmail.com','Pablo Gillespie');
        $mail->addAddress($this->email);
        $mail->Subject ="Confirma tu Cuenta";

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido= '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado una cuenta en DevWevCampo, solo debes confirmarla en el siguiente enlace</p>";
        $contenido .= "<p>Precione aquí: <a href=". $_SERVER['HTTP_ORIGIN'] . "/confirmar-cuenta?token=" . $this->token . ">Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';

        $mail->Body= $contenido;
        $mail->send();
    }

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Username = 'uptaskproyectos@gmail.com';
        $mail->Password = 'hswtlbgdhquhcslc';

        $mail->setFrom('uptaskproyectos@gmail.com','Pablo Gillespie');
        $mail->addAddress($this->email);
        $mail->Subject ="Confirma tu Cuenta";

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido= '<html>';
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has reestablecido tu password, solo debes seguir este enlace para crear uno nuevo</p>";
        $contenido .= "<p>Precione aquí: <a href=". $_SERVER['HTTP_ORIGIN'] . "/reestablecer?token=" . $this->token . ">Reestablecer Password</a></p>";
        $contenido .= "<p>Si tu no creaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= '</html>';

        $mail->Body= $contenido;
        $mail->send();
    }
}
