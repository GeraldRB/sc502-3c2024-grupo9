<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once("../accesoDatos/conexion.php");
$conexion = abrirConexion();



$resultado = null;
//datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  $tituloo = $_POST["titulo"];
  $descripcionn = $_POST["descripcion"];
  $nivell = $_POST["nivel"];
  $fechaI = $_POST["fechaInicio"];
  $fechaF = $_POST["fechaFin"];
  $estadoo = isset($_POST["estado"]) ? 1 : 0;
}

try {

  $sql = "INSERT INTO programas_educativos
        (titulo, descripcion, nivel, fecha_inicio, fecha_fin, estado)
        VALUES (?, ?, ?, ?, ?, ?)";

  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("sssssi", $tituloo, $descripcionn, $nivell, $fechaI, $fechaF, $estadoo);
  $stmt->execute();
  $stmt->close();

        header('Location: ../view/tablas/listaProgramas.php?ok=1'); 
        exit;
} catch (Throwable $e) {
        header('Location: ../view/programas.php?error=1');
        exit;
}



?>