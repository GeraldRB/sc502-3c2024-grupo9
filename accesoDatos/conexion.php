<?php

function abrirConexion() {
    $host = "127.0.0.1";
    $user = "root";
    $password = "12108433"; 
    $db = "guarderia";

    $mysqli = new mysqli($host, $user, $password, $db);

    if ($mysqli->connect_error) {
        throw new Exception("Error de conexión a la base de datos: " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");

    return $mysqli;
}

function cerrarConexion($mysqli) {
    if ($mysqli instanceof mysqli) {
        $mysqli->close();
    }
}
?>