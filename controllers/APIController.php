<?php

namespace Controllers;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() {

        // Almacenar cita y devuelve el id: 
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $citaId = $resultado['id'];
    
        // Almacena los servicios:
        $idServicios = explode(",",$_POST['servicios']); 
        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $citaId,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // Retornar una respuesta:
        echo json_encode(['resultado' => $resultado]);
    }
}

?>

