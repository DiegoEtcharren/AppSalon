<?php 
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email { 

    public $email; 
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {
        // Crear objeto de PHP Mailer: 
        $mail = new PHPMailer();
        $mail->isSMTP();                                           
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '1de049c7e5ef83';
        $mail->Password = '1eccb8a1ae91f0';                              
    
        $mail->setFrom('cuentas@eappsalon.com');
        $mail->addAddress('cuentas@eappsalon.com', 'AppSalon.com');     
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en App Salon. Solo debes confirmarla presionando el siguiente link</p>";
        $contenido .= "<p><a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;
    
        // Enviar mail: 
        $mail->send();
    }
}


?>