<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController {

    public static function login(Router $router) {

        $alertas = [];

        $auth = new Usuario();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {

                //Comprobar que existe el usuario
                $usuario = Usuario::where("email",$auth->email);

                if($usuario) {
                    //Verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        session_start();

                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre . " " . $usuario->apellido1;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;

                        //Redireccionamiento

                        if ($usuario->admin === "1") {
                            header("Location: /admin");
                            $_SESSION["admin"] = true;

                        }  else {
                            header("Location: /cita");
                            $_SESSION["admin"] = false;
                        }
                    }

                } else {
                    Usuario::setAlerta("error","El usuario introducido no está registrado");
                }

            }

        }

        $alertas = Usuario::getAlertas();
        
        $router->render("auth/login", 
        [
            "alertas" => $alertas,
            "auth" => $auth
        ]
        );

    }

    public static function logout() {
        
        $_SESSION = [];
        header("Location:/ ");

    }

    public static function olvide(Router $router) {

        $alertas = [];
        $auth = new Usuario();

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {

                $usuario = Usuario::where("email",$auth->email);
                
                if ($usuario && $usuario->confirmado === "1") {

                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta("exito", "Te hemos enviado un email con las instrucciones para recuperar tu password");

                } else {
                    Usuario::setAlerta("error","El usuario no existe o no está confirmado");
                }

            }
        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/olvide-password", 

        [
            "alertas"=>$alertas,
            "auth"=>$auth
        ]);    
    }

    public static function recuperar(Router $router) {
    
        $alertas = [];
        $token = s($_GET["token"]);
        $error = false;
        $usuario = Usuario::where("token",$token);

        if (empty($usuario)) {
            Usuario::setAlerta("error","El token de seguridad no se valida correctamente");
            $error = true;
        }

        $auth = new Usuario($_POST);

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            $alertas = $auth->validarPassword();
        
            if(empty($alertas)) {
                
                $usuario->password = $auth->password;
                $usuario->hashPassword();
                $usuario->guardar();

                Usuario::setAlerta("exito","Se ha cambiado correctamente su contraseña");

            }

        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/recuperar", 
        [
            "alertas"=>$alertas,
            "error"=>$error
        ]);

    }

    public static function crear(Router $router) {

        $usuario = new Usuario($_POST);
        $alertas = [];


        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $usuario -> sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //Revisar que alertas esté vacío
            if (empty($alertas)) {

                //Hay que revisar que el usuario no exista para insertarlo
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear el password
                    $usuario->hashPassword();

                    //Generar un token unico
                    $usuario->crearToken();

                    //Guardar el usuario sin confirmar en bbdd
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                
                        //Enviar el email
                        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                        $email->enviarConfirmacion();
                        header("Location: /mensaje");
                    }

                }

            }

        }

        $router->render("auth/crear-cuenta", 
        [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router) {

        $router->render("auth/mensaje");

    }


    public static function confirmar(Router $router) {

        $alertas = [];

        $token = s($_GET["token"]);

        $usuario = Usuario::where("token",$token);
        
        if (empty($usuario)) {
            
            Usuario::setAlerta("error","El token de seguridad no se valida correctamente");

        } else {

            Usuario::setAlerta("exito","Su usuario ha sido confirmado satisfactoriamente");
            
            $usuario->confirmado = "1";
            $usuario->token = "";
            $usuario->guardar();

        }

        $alertas = Usuario::getAlertas();

        $router->render("auth/confirmar-cuenta",
        [
            "alertas" => $alertas
        ]
    
    );

    }



}