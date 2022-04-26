<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Funciona que revisa que el usuario esté autenticado

function isAuth() : void {
    if (!isset($_SESSION["login"])) {
        header("Location: /");
    }
}

function isAdmin() : void {
    if (!$_SESSION["admin"]) {
        header("Location: /");
    }
}

function esUltimo($actual,$proximo): bool {
    return ($actual!==$proximo);
}

function validaFecha($fecha) {
    return (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$fecha));
}