<?php
session_start();
require_once '../accesoDatos/conexion.php';

if (!isset($_SESSION['usuarioID'])) {
    header("Location: ../view/login.php?error=" . urlencode("Inicie sesión para continuar."));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/citas.php");
    exit;
}

$usuarioID = $_SESSION['usuarioID'];
$cedula_encargado = trim($_POST['cedula_encargado'] ?? '');
$cedula_nino = trim($_POST['cedula_nino'] ?? '');
$fecha_cita = trim($_POST['fecha_cita'] ?? '');
$motivo = trim($_POST['motivo'] ?? '');

// Validar campos
if (empty($cedula_encargado) || empty($cedula_nino) || empty($fecha_cita) || empty($motivo)) {
    header("Location: ../view/citas.php?err=campos");
    exit;
}

// Validar fecha futura
if (strtotime($fecha_cita) <= time()) {
    header("Location: ../view/citas.php?err=pasado");
    exit;
}

try {
    $conn = abrirConexion();

    // Validar si ya hay una cita agendada para ese usuario en ese horario
    $stmt = $conn->prepare("SELECT id_cita FROM CITAS WHERE id_usuario = ? AND fecha_cita = ?");
    $stmt->bind_param("is", $usuarioID, $fecha_cita);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        cerrarConexion($conn);
        header("Location: ../view/citas.php?err=choque");
        exit;
    }

    // Insertar cita
    $estado = 'Pendiente';
    $stmt = $conn->prepare("INSERT INTO CITAS (id_usuario, fecha_cita, motivo, estado) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $usuarioID, $fecha_cita, $motivo, $estado);

    if ($stmt->execute()) {
        cerrarConexion($conn);
        header("Location: ../view/citas.php?ok=1");
    } else {
        cerrarConexion($conn);
        header("Location: ../view/citas.php?err=ins");
    }

} catch (Exception $e) {
    header("Location: ../view/citas.php?err=ex");
    exit;
}