<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
  header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
  exit;
}

$rol = $_SESSION['id_rol'];
$usuarioID = $_SESSION['usuarioID'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Agendar Cita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f7f9fb;
      font-family: 'Poppins', sans-serif;
    }

    .navbar {
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, .1);
    }

    .navbar-brand img {
      height: 50px;
    }

    h3,
    h4 {
      color: #20b2aa;
      font-weight: 600;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .form-label {
      font-weight: 500;
    }

    .btn-primary {
      background-color: #20b2aa;
      border-color: #20b2aa;
    }

    .btn-primary:hover {
      background-color: #1e9b98;
    }
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
          <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
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


  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <div class="card p-4">
          <h3 class="text-center mb-4">Agendar Cita</h3>

          <?php if (isset($_GET["ok"])): ?>
            <div class="alert alert-success">Cita creada correctamente.</div>
          <?php elseif (isset($_GET["err"])):
            $map = [
              "campos" => "Completá todos los campos.",
              "pasado" => "La fecha/hora debe ser futura.",
              "choque" => "Ya tenés una cita en esa fecha/hora.",
              "ins" => "No se pudo guardar la cita.",
              "ex" => "Error inesperado. Intenta de nuevo."
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
              <label for="fecha_cita" class="form-label">Fecha y hora</label>
              <input type="text" class="form-control" id="fecha_cita" name="fecha_cita"
                placeholder="Seleccioná fecha y hora" required>
            </div>

            <div class="mb-3">
              <label for="motivo" class="form-label">Motivo</label>
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

      <!-- Lista de citas -->
      <div class="col-md-6">
        <div class="card p-4">
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
              if ($res->num_rows === 0) {
                echo '<li class="list-group-item">No tenés citas próximas.</li>';
              } else {
                while ($row = $res->fetch_assoc()) {
                  echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                  echo '<div><strong>' . htmlspecialchars($row["motivo"]) . '</strong><br><small>' . $row["fecha_cita"] . '</small></div>';
                  echo '<span class="badge bg-secondary">' . $row["estado"] . '</span>';
                  echo '</li>';
                }
              }
            } catch (Exception $e) {
              echo '<li class="list-group-item text-danger">No se pudieron cargar las citas.</li>';
            } finally {
              if (isset($cn))
                cerrarConexion($cn);
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