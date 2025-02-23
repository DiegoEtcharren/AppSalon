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
        $mail->Username = 'c39839982590cc';
        $mail->Password = '3fc9b788946388';                              
    
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

    public function enviarInstrucciones() {
        // Crear objeto de PHP Mailer: 
        $mail = new PHPMailer();
        $mail->isSMTP();                                           
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'c39839982590cc';
        $mail->Password = '3fc9b788946388';                              
    
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@eappsalon.com', 'AppSalon.com');     
        $mail->Subject = 'Restablece tu Password';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado, un cambio de contrasena</p>";
        $contenido .= "<p><a href='http://localhost:3000/recuperar?token=" . $this->token."'>Restablecer Constrasena</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cambio, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;
    
        // Enviar mail: 
        $mail->send();
    }
}

?>