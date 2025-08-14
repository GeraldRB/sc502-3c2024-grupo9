<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    exit("ID inválido");
}

$sql = "DELETE FROM programas_educativos WHERE id_programa = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    cerrarConexion($conexion);
    echo '<script>
            alert("El programa se eliminó correctamente.");
            window.location.href = "listaProgramas.php";
          </script>';
    exit;
} else {
    $errorr = $stmt->error;
    cerrarConexion($conexion);
    exit("Error al eliminar: $errorr");
}
?>