<?php
require_once("../accesoDatos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $correo = $_POST["correo"] ?? '';
    $clave  = $_POST["contraseña"] ?? '';

    try {
        $conexion = abrirConexion();

        $consulta = $conexion->prepare("SELECT id_usuario FROM USUARIOS WHERE correo = ?");
        $consulta->bind_param("s", $correo);
        $consulta->execute();
        $resultado = $consulta->get_result();

        if ($resultado->num_rows > 0) {
            header("Location: ../view/registro.php?existe=1");
            exit();
        }

        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        $insertar = $conexion->prepare(
            "INSERT INTO USUARIOS (nombre, correo, contraseña, id_rol) VALUES (?, ?, ?, ?)"
        );
        $id_rol = 2; 
        $insertar->bind_param("sssi", $nombre, $correo, $claveHash, $id_rol);

        if ($insertar->execute()) {
            header("Location: ../view/registro.php?ok=1");
        } else {
            header("Location: ../view/registro.php?error=1");
        }

    } catch (Exception $e) {
        error_log("Error al registrar usuario: " . $e->getMessage());
        header("Location: ../view/registro.php?error=1");
    } finally {
        cerrarConexion($conexion);
    }
} else {
    header("Location: ../view/registro.php");
    exit();
}