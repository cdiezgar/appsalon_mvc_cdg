<?php

namespace Model;

class CitaUsuario extends ActiveRecord {
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ["id","cita","servicio","precio"];

    public $id;
    public $cita;
    public $servicio;
    public $precio;

    public function __construct() {
        $this->id = $args["id"] ?? null;
        $this->cita = $args["cita"] ?? "";
        $this->servicio = $args["servicio"] ?? "";
        $this->precio = $args["precio"] ?? "";
    }

    public static function consultarCitas($idUsuario) {
        //Consultar la base de datos
        $consulta = "SELECT citas.id, concat(citas.fecha,' ',citas.hora) as cita, ";
        $consulta .= " servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas ";
        $consulta .= " INNER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " INNER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId ";
        $consulta .= " WHERE citas.usuarioId = ${idUsuario} ";
        $consulta .= " AND fecha >= SYSDATE() ";
        $consulta .= "ORDER BY citas.hora asc";

        return $consulta;
}


}