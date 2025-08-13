<?php
require_once("../accesoDatos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre  = trim($_POST["nombre"] ?? "");
    $correo  = trim($_POST["correo"] ?? "");
    $mensaje = trim($_POST["mensaje"] ?? "");

    if ($nombre === "" || $correo === "" || $mensaje === "") {
        header("Location: ../view/contacto.php?err=campos");
        exit();
    }

    try {
        $cn = abrirConexion();
        $sql = "INSERT INTO CONTACTO (nombre, correo, mensaje) VALUES (?, ?, ?)";
        $stmt = $cn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $correo, $mensaje);

        if ($stmt->execute()) {
            header("Location: ../view/contacto.php?ok=1");
        } else {
            header("Location: ../view/contacto.php?err=insert");
        }
        exit();
    } catch (Exception $e) {
        error_log("CONTACTO ERROR: " . $e->getMessage());
        header("Location: ../view/contacto.php?err=ex");
        exit();
    } finally {
        if (isset($cn)) cerrarConexion($cn);
    }
} else {
    header("Location: ../view/contacto.php");
    exit();
}