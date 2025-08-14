<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
    header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
    exit;
}

$rol = $_SESSION['id_rol']; // 1 = admin, 2 = encargado
$usuarioID = $_SESSION['usuarioID'];

$errores = isset($_GET['error']) ? explode('|', $_GET['error']) : [];
$ok = isset($_GET['success']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agendar Cita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, .1);
    }

    .navbar-brand img {
      height: 50px;
    }

    .card h3, .card h4 {
      color: #20b2aa;
    }
  </style>
</head>
<body class="bg-light">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand" href="index.php">
      <img src="../public/logo.jpg" alt="REDCUDI Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <?php if ($rol == 1 || $rol == 2): ?>
          <li class="nav-item"><a class="nav-link" href="recomendaciones.php">Recomendaciones</a></li>
          <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
          <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
          <li class="nav-item"><a class="nav-link active" href="citas.php">Citas</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
        <?php if ($rol == 1): ?>
          <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
          <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- CONTENIDO -->
  <div class="container py-5">
    <div class="row justify-content-center">
      <!-- Formulario -->
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h3 class="mb-3 text-center">Agendar Cita</h3>

          <?php if (isset($_GET["ok"])): ?>
            <div class="alert alert-success">Cita creada correctamente.</div>
          <?php elseif (isset($_GET["err"])): 
              $map = [
                "campos"=>"Completá todos los campos.",
                "pasado"=>"La fecha/hora debe ser futura.",
                "choque"=>"Ya tenés una cita en esa fecha/hora.",
                "ins"=>"No se pudo guardar la cita.",
                "ex"=>"Error inesperado. Intenta de nuevo."
              ];
              $msg = $map[$_GET["err"]] ?? "Error.";
          ?>
            <div class="alert alert-danger"><?php echo $msg; ?></div>
          <?php endif; ?>

          <form method="POST" action="../controller/citas.php">
            <div class="mb-3">
              <label for="cedula_encargado" class="form-label">Cédula del Encargado</label>
              <input type="text" class="form-control" id="cedula_encargado" name="cedula_encargado" required>
            </div>

            <div class="mb-3">
              <label for="cedula_nino" class="form-label">Cédula del Niño</label>
              <input type="text" class="form-control" id="cedula_nino" name="cedula_nino" required>
            </div>

            <div class="mb-3">
              <label for="fecha_cita" class="form-label">Fecha y hora de la cita</label>
              <input type="text" class="form-control" id="fecha_cita" name="fecha_cita" placeholder="Seleccioná fecha y hora" required>
            </div>

            <div class="mb-3">
              <label for="motivo" class="form-label">Motivo de la cita</label>
              <select class="form-select" id="motivo" name="motivo" required>
                <option value="">Seleccione un motivo</option>
                <option>Consulta de programas</option>
                <option>Pagos</option>
                <option>Información general</option>
                <option>Reclamos</option>
                <option>Otros</option>
              </select>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Lista de próximas citas -->
      <div class="col-md-6 mt-4 mt-md-0">
        <div class="card p-4 shadow-sm">
          <h4 class="mb-3">Mis próximas citas</h4>
          <ul class="list-group">
          <?php
            require_once("../accesoDatos/conexion.php");
            try {
              $cn = abrirConexion();
              $q = $cn->prepare("SELECT fecha_cita, motivo, estado FROM CITAS WHERE id_usuario = ? AND fecha_cita >= NOW() ORDER BY fecha_cita ASC LIMIT 20");
              $q->bind_param("i", $usuarioID);
              $q->execute();
              $res = $q->get_result();
              if ($res->num_rows === 0){
                echo '<li class="list-group-item">No tenés citas próximas.</li>';
              } else {
                while($row = $res->fetch_assoc()){
                  echo '<li class="list-group-item">';
                  echo '<strong>'.htmlspecialchars($row["motivo"]).'</strong> — ';
                  echo $row["fecha_cita"].' <span class="badge bg-secondary ms-2">'.$row["estado"].'</span>';
                  echo '</li>';
                }
              }
            } catch (Exception $e) {
              echo '<li class="list-group-item text-danger">No se pudieron cargar las citas.</li>';
            } finally {
              if (isset($cn)) cerrarConexion($cn);
            }
          ?>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#fecha_cita", {
      enableTime: true,
      dateFormat: "Y-m-d H:i",
      time_24hr: true,
      minDate: "today"
    });
  </script>
</body>
</html>