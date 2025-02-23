<?php 

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = [
        'id',
        'hora',
        'cliente',
        'telefono',
        'email',
        'nombre',
        'precio'
    ];

    public $id;
    public $hora;
    public $cliente;
    public $telefono;
    public $email;
    public $nombre;
    public $precio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? ''; 
    }
}

?>