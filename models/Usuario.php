<?php

namespace Model;

class Usuario extends ActiveRecord {

    //Base de datos
    protected static $tabla = "usuarios";
    protected static $columnasDB = ["id","nombre","apellido1","email","password","telefono",
        "admin","confirmado","token"];

    public $id;
    public $nombre;
    public $apellido1;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct ($args = []) {

        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->apellido1 = $args["apellido1"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->password = $args["password"] ?? "";
        $this->telefono = $args["telefono"] ?? "";
        $this->admin = $args["admin"] ?? "0";
        $this->confirmado = $args["confirmado"] ?? "0";
        $this->token = $args["token"] ?? "";

    }

    //Validaciones
    public function validarNuevaCuenta() {

        if (!$this->nombre) {
            self::$alertas["error"][] = "Es necesario que introduzcas tu nombre";
        }

        if (!$this->apellido1) {
            self::$alertas["error"][] = "Es necesario que introduzcas tu primer apellido";
        }

        if (!$this->telefono) {
            self::$alertas["error"][] = "Es obligatorio informar un número de teléfono";
        }

        if ($this->telefono && (!preg_match("/^6[0-9]{8}$/",$this->telefono) && !preg_match("/^[9|8|6|7][0-9]{8}$/",$this->telefono))) {
            self::$alertas["error"][] = "Debes informar un número de teléfono válido";
        }

        $this->validarEmail();

        $this->validarPassword();

        return self::$alertas;

    }

    public function validarLogin() {

        if (!$this->email) {
            self::$alertas["error"][] = "Debes informar tu email para poder acceder a la aplicación";
        }

        if ($this->email && !preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/',$this->email)) {
            self::$alertas["error"][] = "El email informado no es válido";
        }
        
        if (!$this->password) {
            self::$alertas["error"][] = "Debes informar tu clave para acceder a la aplicación";
        }

        return self::$alertas;
    }

    public function validarEmail() {
        if (!$this->email) {
            self::$alertas["error"][] = "Debes informar tu email para poder acceder a la aplicación";
        }

        if ($this->email && !preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/',$this->email)) {
            self::$alertas["error"][] = "El email informado no es válido";
        }

        return self::$alertas;
    }

    public function validarPassword() {
        if (!$this->password) {
            self::$alertas["error"][] = "La clave de acceso no puede estar vacía";
        }

        if ($this->password && strlen($this->password) <6 ) {
            self::$alertas["error"][] = "La clave de acceso debe contener al menos 6 caractéres";
        }

        return self::$alertas;
    }

    //Revisa si el usuario ya existe en BBDD
    public function existeUsuario() {
        
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {
            self::$alertas["error"][] = "El Usuario ya está registrado";
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado ($password) {

        $resultado = password_verify($password,$this->password);

        if (!$resultado || !$this->confirmado) {
            self::$alertas["error"][] = "El usuario no está confirmado o la clave de acceso no es correcta";
        } else {
            return true;
        }
        
    }

    


}