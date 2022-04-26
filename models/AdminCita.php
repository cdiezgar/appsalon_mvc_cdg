<?php

namespace Model;

class AdminCita extends ActiveRecord {
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ["id","hora","cliente","email","telefono","servicio","precio"];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct() {
        $this->id = $args["id"] ?? null;
        $this->hora = $args["hora"] ?? "";
        $this->cliente = $args["cliente"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->servicio = $args["servicio"] ?? "";
        $this->precio = $args["precio"] ?? "";
    }

    public static function consultarCitas($fecha) {
               //Consultar la base de datos
               $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido1) as cliente, ";
               $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
               $consulta .= " FROM citas  ";
               $consulta .= " INNER JOIN usuarios ";
               $consulta .= " ON citas.usuarioId=usuarios.id  ";
               $consulta .= " INNER JOIN citas_servicios ";
               $consulta .= " ON citas_servicios.citaId=citas.id ";
               $consulta .= " INNER JOIN servicios ";
               $consulta .= " ON servicios.id=citas_servicios.servicioId ";
               $consulta .= " WHERE citas.fecha = '${fecha}' ";
               $consulta .= "ORDER BY citas.hora asc";
               return $consulta;
    }


}