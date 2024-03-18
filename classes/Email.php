<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email,$nombre,$token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }


    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = 'true';
        $mail->Port = 465;
        $mail->Username = 'abrahamgar91@gmail.com';
        $mail->Password = 'DarkHope080891';

        $mail->setFrom('Cuentas@cuentas.com');
        $mail->addAddress('cuentas@cuentas.com', 'abi.com');
        $mail->Subject = 'Confirma tu cuenta';
        
    }
    

}