<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    exit("ID inválido");
}

$sql = "DELETE FROM programas_educativos WHERE id_programa = $id";

if ($conexion->query($sql)) {

    cerrarConexion($conexion);

    echo '<script>
            alert("El programa se eliminó correctamente.");
            window.location.href = "listaProgramas.php";
          </script>';
    exit;

} else {
    $errorr = $conexion->error;
    cerrarConexion($conexion);
    exit("Error al eliminar: $errorr");
}

?>