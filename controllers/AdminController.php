<?php 

namespace Controllers;

use MVC\Router;
use Model\AdminCita;
use Model\AdminCitas;

class AdminController {
    public static function index( Router $router){
        isSession();
        isAdmin();
        // Consultar base de datos:
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404');
        };
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as nombre, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '{$fecha}'";
        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index',
        [
            'nombre' => $_SESSION['nombre'] ?? null,
            'citas'=> $citas,
            'fecha' => $fecha
        ]);
    }
}

?>