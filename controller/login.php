<?php
session_start();
require_once("../accesoDatos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = trim($_POST["correo"] ?? '');
    $clave = trim($_POST["contraseña"] ?? '');

    try {
        $conexion = abrirConexion();

        $stmt = $conexion->prepare("SELECT id_usuario, nombre, correo, contraseña, estado FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if ($clave === trim($usuario["contraseña"])) {
                if ($usuario["estado"] == 1) {
                    $_SESSION["nombreUsuario"] = $usuario["nombre"];
                    $_SESSION["idUsuario"] = $usuario["id_usuario"];
                    header("Location: ../view/index.php"); 
                    exit();
                } else {
                    header("Location: ../view/login.php?error=2"); 
                    exit();
                }
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