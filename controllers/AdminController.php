<?php

namespace Controllers;

use Model\Cita;
use MVC\Router;
use Model\AdminCita;

class AdminController{

    public static function index (Router $router) {

        isAdmin();


        $fecha = $_GET["fecha"] ?? date("Y-m-d");
        $fechas = explode("-",$fecha);

        if (!validaFecha($fecha)) {
            AdminCita::setAlerta("error","No me trolees con la fecha de la url...");
        } else {
            
            if (!checkdate($fechas[1],$fechas[2],$fechas[0])) {
                header("Location: /404");
            }
        }

        $citas = AdminCita::SQL(AdminCita::consultarCitas($fecha));
        
        $alertas = AdminCita::getAlertas();
        $router->render("admin/index",
        [
            "nombre" => $_SESSION["nombre"],
            "citas" => $citas,
            "fecha" => $fecha,
            "alertas" => $alertas
        ]);
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