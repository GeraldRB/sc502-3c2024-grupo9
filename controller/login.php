<?php
session_start();
require_once("../accesoDatos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"] ?? '';
    $clave = $_POST["contraseña"] ?? '';

    try {
        $conexion = abrirConexion();

        $stmt = $conexion->prepare("SELECT nombre, contraseña FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if ($clave === $usuario["contraseña"]) {
                $_SESSION["nombreUsuario"] = $usuario["nombre"];
                header("Location: ../view/index.php");
                exit();
            }
        }

        header("Location: ../view/login.php?error=1");
        exit();

    } catch (Exception $e) {
        error_log("Error al iniciar sesión: " . $e->getMessage());
        header("Location: ../view/login.php?error=1");
        exit();
    } finally {
        if (isset($conexion)) {
            cerrarConexion($conexion);
        }
    }
} else {
    header("Location: ../view/login.php");
    exit();
}