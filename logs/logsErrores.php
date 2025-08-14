<?php
function registrarError($descripcion, $nivel = "ERROR", $pantalla = null, $usuario = null) {
    date_default_timezone_set("America/Costa_Rica");

    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    if ($pantalla === null) {
        $pantalla = basename($_SERVER['PHP_SELF']);
    }

    if ($usuario === null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); 
        }
        $usuario = $_SESSION['nombreUsuario'] ?? $_SESSION['nombre'] ?? "Invitado";
    }

    $linea = "[$fecha $hora] [$nivel] $descripcion | Pantalla: $pantalla | Usuario: $usuario" . PHP_EOL;

    $ruta = __DIR__ . "/logs.txt";
    file_put_contents($ruta, $linea, FILE_APPEND);
}
?>