<?php
require_once("../accesoDatos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cedula_encargado = trim($_POST["cedula_encargado"] ?? "");
    $cedula_nino      = trim($_POST["cedula_nino"] ?? "");
    $fecha_cita       = trim($_POST["fecha_cita"] ?? "");
    $motivo           = trim($_POST["motivo"] ?? "");

    if ($cedula_encargado === "" || $cedula_nino === "" || $fecha_cita === "" || $motivo === "") {
        header("Location: ../view/citas.php?err=campos");
        exit();
    }

    try {
        $cn = abrirConexion();

        // prototipo id_usuario = 1 o el que este loguead
        // si se manjea una sesion se remplaza por $_SESSION['id_usuario'].
        $idUsuario = 1;

        // se valida que la fecha y hora seam futura
        $dt = new DateTime($fecha_cita);
        if ($dt < new DateTime()) {
            header("Location: ../view/citas.php?err=pasado");
            exit();
        }

        // Se valida choque de cita (misma fecha y hora para el mismo usuario)
        $chk = $cn->prepare("SELECT COUNT(*) AS total FROM CITAS WHERE id_usuario = ? AND fecha_cita = ?");
        $chk->bind_param("is", $idUsuario, $fecha_cita);
        $chk->execute();
        $r = $chk->get_result()->fetch_assoc();
        if ((int)$r["total"] > 0) {
            header("Location: ../view/citas.php?err=choque");
            exit();
        }

        // se inserta la cita
        $ins = $cn->prepare("INSERT INTO CITAS (id_usuario, fecha_cita, motivo, estado) VALUES (?, ?, ?, 'Pendiente')");
        $ins->bind_param("iss", $idUsuario, $fecha_cita, $motivo);

        if ($ins->execute()) {
            header("Location: ../view/citas.php?ok=1");
        } else {
            header("Location: ../view/citas.php?err=ins");
        }
        exit();

    } catch (Exception $e) {
        error_log("CITAS ERROR: " . $e->getMessage());
        header("Location: ../view/citas.php?err=ex");
        exit();
    } finally {
        if (isset($cn)) cerrarConexion($cn);
    }
} else {
    header("Location: ../view/citas.php");
    exit();
}