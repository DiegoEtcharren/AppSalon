<?php 
namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController {
    public static function index(Router $router){

        isSession();
        isAdmin();
        $servicios = Servicio::all();

        $router->render('/servicios/index', [
            'nombre' => $_SESSION['nombre'] ?? null, 
            'servicios' => $servicios, 
        ]);
    }

    public static function crear(Router $router){

        isSession();
        isAdmin();
        $servicio = new Servicio;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if (empty($alertas)) {
                $resultado = $servicio->guardar();
                if ($resultado['resultado']) {
                    header("Location: /servicios");
                    exit;
                }
            }
        };

        $router->render('/servicios/crear', [
            'nombre' => $_SESSION['nombre'] ?? null, 
            'servicio' => $servicio ?? null,
            'alertas' => $alertas
        ]);
        
    }

    public static function actualizar(Router $router){
        
        isSession();
        isAdmin();
        $alertas = [];
        if(!is_numeric($_GET['id'])) : 
            header("Location: /servicios");
            exit;
        endif;

        $id = $_GET['id'];
        $servicio = Servicio::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if (empty($alertas)) {
                $resultado = $servicio->guardar();
                if ($resultado) {
                    header("Location: /servicios");
                    exit;
                }
            }
        }

        $router->render('/servicios/actualizar', [
            'nombre' => $_SESSION['nombre'] ?? null,
            'servicio' => $servicio ?? null,
            'alertas' => $alertas
        ]);
        
    }

    public static function eliminar(){
        isSession();
        isAdmin();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $resultado = $servicio->eliminar();
            if ($resultado) {
                header("Location: /servicios");
                exit;
            }
        } 

    }

}
?>