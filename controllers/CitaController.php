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

    public static function eliminar (Router $router) {
        
        isAuth();

        $idUsuario = $_SESSION["id"];

        $citas = Cita::all();

        if ($_SERVER['REQUEST_METHOD'] ==="POST") {

    
            $id = $_POST["id"];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        
            if ($id) {
                $eliminar = Cita::find($id);
                $resultado = $eliminar->eliminar();

                if ($resultado) {
                    header("Location: /misCitas");
                    $citas = CitaUsuario::consultarSQL(CitaUsuario::consultarCitas($idUsuario));
                }
            

            }
        }

        $router->render("cita/misCitas" ,
        [

        ]);


    }

}