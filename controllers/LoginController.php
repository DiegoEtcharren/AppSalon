<?php 

namespace Controllers;
use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {

    public static function login(Router $router){

        $auth = new Usuario;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if (empty($alertas)) {
                // Comprobar que exista el usuario: 
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    // Verificar el password:
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        
                        // Loggear al usuario:
                        isSession();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento: 
                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                }
            } else {
                Usuario::setAlerta('error', 'Usuario no encontrado');
            }
        }

        $alertas = Usuario::getAlertas();   
        $router->render('auth/login',[
            'alertas' => $alertas, 
            'auth' => $auth
        ]);
    }

    public static function logout(){
        $_SESSION = array();
        session_destroy();

        isAuth();
    }

    public static function olvide(Router $router){
        $alertas = [];
        $auth = new Usuario;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado === '1') {
                    // Generar un token:
                    $usuario->crearToken();
                    $usuario->guardar();
                    // TODO: Enviar email:
                    $email = new Email($usuario->email,$usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de Exito: 
                    Usuario::setAlerta('exito', 'Correo Enviado');



                } else {
                    Usuario::setAlerta('error', 'No existe el usuario o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password',
        [
            'alertas' => $alertas, 
            'auth' => $auth
        ]);
    }

    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Error en Token');
            $error = true;
        }

        // Leer el nuevo password y actualizar:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();
            if (empty($alertas)) {
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if ($resultado) { 
                    header('Location: /');
                }

            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar',
        [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function confirmar(Router $router){
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);


        if (empty($usuario)) {
            // Mostrar mensaje de error:
            Usuario::setAlerta('error', 'Token no valido');

        } else {
            // Actualizar confirmado: 
            $usuario->confirmado = 1;
            $usuario->token = '';
            $usuario->guardar();
            
            // Mostrar mensaje de correcto:
            Usuario::setAlerta('exito', 'Cuenta Creada Correctamente');
        }
        
        // Obtener alertas:
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',
        [
            'alertas' => $alertas,
            'token' => $token
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function crear(Router $router){
        $usuario = new Usuario();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            // Revisar que alertas errores este vacio: 
            if (empty($alertas)) {
                // Verificar que la cuenta no existe:
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // No esta registrado:
                    $usuario->hashPassword();
                    
                    // Generar Token:
                    $usuario->crearToken();

                    // Enviar email con token: 
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario: 
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }   
        $router->render('auth/crear-cuenta',
        [
            'usuario'=> $usuario, 
            'alertas' => $alertas
        ]);
    }
    
}

?>