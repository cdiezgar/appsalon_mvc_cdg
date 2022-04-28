<?php

namespace Controllers;

use Model\Cita;
use Model\Servicio;
use Model\CitaServicio;

class APIController {

    public static function index() {

        $servicios = Servicio::all();
        json_encode($servicios, JSON_UNESCAPED_UNICODE);

    }

    public static function guardar() {

        $cita = new Cita($_POST);

        $resultado = $cita->guardar();

        $id = $resultado["id"];

        //Almacena los servicios con el id de la cita
        $idServicios = explode(",", $_POST["servicios"]);
        foreach($idServicios as $idServicio) {
            $args = [
                "citaId" => $id,
                "servicioId" => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        
        echo json_encode(["resultado" => $resultado]);

    }

    public static function eliminarDesdeCliente() {

        $cita = Cita::find($_POST["id"]);

        $resultado = $cita->eliminar();

        echo json_encode(["resultado" => $resultado]);

    }

    public static function eliminarDesdeAdmin() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $id = $_POST["id"];

            $cita = Cita::find($id);

            $cita->eliminar();

            header("Location: " . $_SERVER ["HTTP_REFERER"]);

        }

    }

}