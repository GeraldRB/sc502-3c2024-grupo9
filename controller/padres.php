<?php
require_once("../accesoDatos/conexion.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: ../view/padres.php");
  exit();
}

$padre_nombre     = trim($_POST["padre_nombre"] ?? "");
$padre_correo     = trim($_POST["padre_correo"] ?? "");
$padre_contrasena = trim($_POST["padre_contrasena"] ?? "");
$nino_nombre      = trim($_POST["nino_nombre"] ?? "");
$nino_nacimiento  = trim($_POST["nino_nacimiento"] ?? "");

if ($padre_nombre==="" || $padre_correo==="" || $padre_contrasena==="" ||
    $nino_nombre==="" || $nino_nacimiento==="") {
  header("Location: ../view/padres.php?err=campos");
  exit();
}

try {
  $cn = abrirConexion();
  $cn->begin_transaction();

  /* asumimos el rol 'Padre' */
  $rolStmt = $cn->prepare("SELECT id_rol FROM ROLES WHERE nombre_rol='Padre' LIMIT 1");
  $rolStmt->execute();
  $rolRes = $rolStmt->get_result();
  if ($rolRes->num_rows === 0) { throw new Exception("No existe rol Padre"); }
  $idRolPadre = (int)$rolRes->fetch_assoc()["id_rol"];

  /* buscamos si ya existe el padre por correo */
  $q = $cn->prepare("SELECT id_usuario FROM USUARIOS WHERE correo=? LIMIT 1");
  $q->bind_param("s", $padre_correo);
  $q->execute();
  $r = $q->get_result();

  if ($r->num_rows > 0) {
    $idPadre = (int)$r->fetch_assoc()["id_usuario"];
  } else {
    
    /* si no se crea el padre */
    $hash = password_hash($padre_contrasena, PASSWORD_DEFAULT);
    $ins = $cn->prepare(
      "INSERT INTO USUARIOS (nombre, correo, `contraseña`, id_rol, estado, fecha_registro)
       VALUES (?, ?, ?, ?, 1, NOW())"
    );
    $ins->bind_param("sssi", $padre_nombre, $padre_correo, $hash, $idRolPadre);
    if (!$ins->execute()) throw new Exception("No se pudo crear el padre");
    $idPadre = $cn->insert_id;
  }

  /* se asocia el niño con el padre */
  $insN = $cn->prepare(
    "INSERT INTO NINOS (nombre, fecha_nacimiento, id_usuario_padre) VALUES (?, ?, ?)"
  );
  $insN->bind_param("ssi", $nino_nombre, $nino_nacimiento, $idPadre);
  if (!$insN->execute()) throw new Exception("No se pudo crear el niño");

  $cn->commit();
  header("Location: ../view/padres.php?ok=1");
  exit();

} catch (Exception $e) {
  if (isset($cn)) $cn->rollback();
  error_log("PADRES ERROR: ".$e->getMessage());
  header("Location: ../view/padres.php?err=ex");
  exit();
} finally {
  if (isset($cn)) cerrarConexion($cn);
}
