<?php
require_once("../accesoDatos/conexion.php");
session_start();

if (!isset($_SESSION["usuarioID"])) {
  header("Location: ../view/login.php?error=" . urlencode("Debe iniciar sesión."));
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $nombre  = trim($_POST["nombre"] ?? "");
  $correo  = trim($_POST["correo"] ?? "");
  $mensaje = trim($_POST["mensaje"] ?? "");
  $idUsuario = $_SESSION["usuarioID"];

  if ($nombre === "" || $correo === "" || $mensaje === "") {
    header("Location: ../view/contacto.php?err=1");
    exit;
  }

  try {
    $cn = abrirConexion();

    if (!$cn) {
      throw new Exception("No se pudo establecer conexión con la base de datos.");
    }

    $stmt = $cn->prepare("INSERT INTO CONTACTO (nombre, correo, mensaje, fecha_envio, id_usuario) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("sssi", $nombre, $correo, $mensaje, $idUsuario);
    $stmt->execute();

    $stmt->close();
    cerrarConexion($cn);
    header("Location: ../view/contacto.php?ok=1");
    exit;

  } catch (Exception $e) {
    if (isset($cn)) cerrarConexion($cn);
    header("Location: ../view/contacto.php?err=1");
    exit;
  }
}
