<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) exit("ID inválido");

$sql = "DELETE FROM usuarios WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    cerrarConexion($conexion);
    echo '<script>
            alert("Usuario eliminado correctamente.");
            window.location.href = "listaUsuarios.php";
          </script>';
    exit;
} else {
    $error = $stmt->error;
    cerrarConexion($conexion);
    exit("Error al eliminar: $error");
}
?>