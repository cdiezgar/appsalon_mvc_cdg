<?php

namespace Controllers;

use Model\Cita;
use MVC\Router;
use Model\CitaUsuario;

class CitaController {
    
    public static function index (Router $router) {

        isAuth();

        $router->render("cita/index" ,
        [
            "nombre" => $_SESSION["nombre"],
            "id" => $_SESSION["id"],
        ]);

    }

    public static function misCitas(Router $router) {

        isAuth();

        $id = $_SESSION["id"];

        $citas = CitaUsuario::consultarSQL(CitaUsuario::consultarCitas($id));


        $router->render("cita/misCitas" ,
        [
            "nombre" => $_SESSION["nombre"],
            "id" => $id,
            "citas" => $citas,
        ]);

    }


}