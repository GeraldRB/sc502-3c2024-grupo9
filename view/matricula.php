<?php
session_start();
if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
  header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
  exit;
}
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
require_once("../accesoDatos/conexion.php");
$rol = (int) $_SESSION['id_rol'];
$usuarioID = (int) $_SESSION['usuarioID'];
$listaProgramas = [];
$listaNinos = [];
$okMsg = null;
$errMsgs = [];
try {
  $cn = abrirConexion();
  $stmtP = $cn->prepare("SELECT id_programa, titulo FROM programas_educativos WHERE estado = 1 ORDER BY titulo");
  $stmtP->execute();
  $rsP = $stmtP->get_result();
  $listaProgramas = $rsP->fetch_all(MYSQLI_ASSOC);
  $stmtP->close();
  $stmtN = $cn->prepare("SELECT id_nino, nombre FROM ninos WHERE id_usuario_padre = ? ORDER BY nombre");
  $stmtN->bind_param("i", $usuarioID);
  $stmtN->execute();
  $rsN = $stmtN->get_result();
  $listaNinos = $rsN->fetch_all(MYSQLI_ASSOC);
  $stmtN->close();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nino = isset($_POST['id_nino']) ? (int) $_POST['id_nino'] : 0;
    $id_programa = isset($_POST['id_programa']) ? (int) $_POST['id_programa'] : 0;
    $fecha_mat_raw = trim($_POST['fecha_matricula'] ?? '');
    if ($id_nino <= 0) $errMsgs[] = "Debe seleccionar un niño.";
    if ($id_programa <= 0) $errMsgs[] = "Debe seleccionar un programa.";
    if ($fecha_mat_raw === '') {
      $errMsgs[] = "Debe indicar la fecha de matrícula.";
    } else {
      $hoy = new DateTime('today');
      $fechaMat = DateTime::createFromFormat('Y-m-d', $fecha_mat_raw);
      if (!$fechaMat) $errMsgs[] = "La fecha de matrícula no tiene un formato válido.";
      if (isset($fechaMat) && $fechaMat > $hoy) $errMsgs[] = "La fecha de matrícula no puede ser en el futuro.";
    }
    if (empty($errMsgs)) {
      $stmtChkN = $cn->prepare("SELECT 1 FROM ninos WHERE id_nino = ? AND id_usuario_padre = ?");
      $stmtChkN->bind_param("ii", $id_nino, $usuarioID);
      $stmtChkN->execute();
      $stmtChkN->store_result();
      if ($stmtChkN->num_rows === 0) $errMsgs[] = "El niño seleccionado no pertenece al usuario actual.";
      $stmtChkN->close();
    }
    if (empty($errMsgs)) {
      $stmtChkP = $cn->prepare("SELECT 1 FROM programas_educativos WHERE id_programa = ? AND estado = 1");
      $stmtChkP->bind_param("i", $id_programa);
      $stmtChkP->execute();
      $stmtChkP->store_result();
      if ($stmtChkP->num_rows === 0) $errMsgs[] = "El programa seleccionado no está activo.";
      $stmtChkP->close();
    }
    if (empty($errMsgs)) {
      $stmtDup = $cn->prepare("SELECT 1 FROM matricula WHERE id_nino = ? AND id_programa = ?");
      $stmtDup->bind_param("ii", $id_nino, $id_programa);
      $stmtDup->execute();
      $stmtDup->store_result();
      if ($stmtDup->num_rows > 0) $errMsgs[] = "Ya existe una matrícula para ese niño en el programa seleccionado.";
      $stmtDup->close();
    }
    if (empty($errMsgs)) {
      $stmtIns = $cn->prepare("INSERT INTO matricula (id_nino, id_programa, fecha_matricula) VALUES (?, ?, ?)");
      $fechaParam = $fecha_mat_raw;
      $stmtIns->bind_param("iis", $id_nino, $id_programa, $fechaParam);
      if ($stmtIns->execute()) {
        $okMsg = "Matrícula registrada correctamente.";
      } else {
        $errMsgs[] = "No se pudo registrar la matrícula.";
      }
      $stmtIns->close();
    }
  }
  cerrarConexion($cn);
} catch (Exception $e) {
  $errMsgs[] = "Error inesperado: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Matrícula</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    .navbar { background-color: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .navbar-brand img { height: 50px; }
    body { font-family: 'Poppins', sans-serif; background-color: #f0f9ff; min-height: 100vh; display: flex; flex-direction: column; }
    main { flex: 1; background: url("../public/backgrand2.jpg") center center/cover no-repeat; background-size: 100%; min-height: 80vh; position: relative; display: flex; align-items: center; justify-content: center; }
    main::before { content: ""; position: absolute; inset: 0; background-color: rgba(255,255,255,0.8); z-index: 1; }
    main > * { position: relative; z-index: 2; }
    .card { padding: 2rem; margin-top: 3px; width: 100%; max-width: 520px; border-radius: 1rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1); background: #fff; }
    .logo { width: 150px; display: block; margin: 0 auto 1rem; }
    .btn-success { background-color: #20b2aa; border-color: #20b2aa; }
    .btn-success:hover { background-color: #198c85; border-color: #198c85; }
    footer { background-color: #20b2aa; color: white; padding: 12px 20px; text-align: center; font-size: 0.9rem; }
    footer p { margin: 3px 0; }
    .form-title { color: #0f766e; font-weight: 700; text-align: center; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; gap: .5rem; }
    .badge-soft { background: #e6fffa; color: #0f766e; border: 1px solid #99f6e4; padding: .35rem .6rem; border-radius: .5rem; font-size: .85rem; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light px-4">
    <a class="navbar-brand" href="index.php">
      <img src="../public/logo.jpg" alt="REDCUDI Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <?php if ($rol == 1 || $rol == 2): ?>
          <li class="nav-item"><a class="nav-link" href="recomendaciones.php">Recomendaciones</a></li>
          <li class="nav-item"><a class="nav-link active" href="matricula.php">Matrícula</a></li>
          <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
          <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
        <?php if ($rol == 1): ?>
          <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
          <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
          <li class="nav-item"><a class="nav-link" href="usuarios/listaUsuarios.php">Lista de Usuarios</a></li>
        <?php endif; ?>
        <?php if ($rol == 3): ?>
          <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  <main class="shadow">
    <div class="card shadow">
      <img src="../public/logo.jpg" alt="REDCUDI Logo" class="logo">
      <div class="d-flex justify-content-center mb-2">
      </div>
      <h3 class="form-title"><span>Formulario de Matrícula</span></h3>
      <?php if (!empty($okMsg)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($okMsg) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
      <?php endif; ?>
      <?php if (!empty($errMsgs)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            <?php foreach ($errMsgs as $e): ?>
              <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
      <?php endif; ?>
      <form method="POST" novalidate>
        <div class="mb-3">
          <label for="id_nino" class="form-label">Nombre del Niño</label>
          <select class="form-select" id="id_nino" name="id_nino" required>
            <option value="" selected disabled>Seleccione un niño...</option>
            <?php foreach ($listaNinos as $n): ?>
              <option value="<?= htmlspecialchars($n['id_nino']) ?>"><?= htmlspecialchars($n['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="id_programa" class="form-label">Programa</label>
          <select class="form-select" id="id_programa" name="id_programa" required>
            <option value="" selected disabled>Seleccione un programa...</option>
            <?php foreach ($listaProgramas as $p): ?>
              <option value="<?= htmlspecialchars($p['id_programa']) ?>"><?= htmlspecialchars($p['titulo']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="fecha_matricula" class="form-label">Fecha de Matrícula</label>
          <input type="date" class="form-control" id="fecha_matricula" name="fecha_matricula" required value="<?= htmlspecialchars((new DateTime())->format('Y-m-d')) ?>">
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-success">Registrar Matrícula</button>
        </div>
      </form>
    </div>
  </main>
  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I.</p>
    <p><strong>Provincia:</strong> San José &nbsp;&nbsp; <strong>Cantón:</strong> San José</p>
    <p><strong>Distrito:</strong> Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Pley, contiguo a Iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2221-7722</p>
    <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>