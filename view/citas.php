<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
    header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
    exit;
}

require_once("../accesoDatos/conexion.php");

$rol = $_SESSION['id_rol'];
$usuarioID = $_SESSION['usuarioID'];
$ok = isset($_GET['ok']);
$err = $_GET['err'] ?? null;

$citas = [];

if ($rol == 1) {
    $conn = abrirConexion();
    $res = $conn->query("SELECT C.*, U.nombre AS encargado FROM citas C INNER JOIN usuarios U ON C.id_usuario = U.id_usuario ORDER BY fecha_cita DESC");
    while ($row = $res->fetch_assoc()) {
        $citas[] = $row;
    }
    cerrarConexion($conn);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Citas | Guardería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        html, body {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f0f9ff;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 50px;
        }

        .nav-link {
            color: #333;
            margin: 0 10px;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #20b2aa;
        }

        .card {
            max-width: 600px;
            margin: 40px auto;
            padding: 2rem;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #20b2aa;
            border-color: #20b2aa;
        }

        .btn-primary:hover {
            background-color: #198c85;
            border-color: #198c85;
        }

        footer {
            background-color: #20b2aa;
            color: white;
            text-align: center;
            padding: 15px 10px;
            font-size: 0.9rem;
        }

        table {
            margin: 20px auto;
            width: 95%;
            max-width: 900px;
            background-color: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #e6f7f5;
        }

        .alert {
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand" href="index.php">
        <img src="../public/logo.jpg" alt="REDCUDI Logo">
    </a>
    <div class="collapse navbar-collapse justify-content-end">
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
                <li class="nav-item"><a class="nav-link" href="usuarios/listaUsuarios.php">Lista de Usuarios</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<main>
<?php if ($rol == 2): ?>
    <div class="card">
        <h3 class="text-center mb-4" style="color: #20b2aa; font-weight: 600;">
    <i class="fas fa-calendar-plus me-2"></i>Agendar una nueva cita
</h3>


        <?php if ($ok): ?>
            <div class="alert alert-success">Cita creada correctamente.</div>
        <?php elseif ($err === "campos"): ?>
            <div class="alert alert-danger">Todos los campos son obligatorios.</div>
        <?php elseif ($err === "pasado"): ?>
            <div class="alert alert-danger">La fecha ingresada ya pasó.</div>
        <?php elseif ($err === "choque"): ?>
            <div class="alert alert-danger">Ya tiene una cita agendada para ese momento.</div>
        <?php elseif ($err === "formato"): ?>
            <div class="alert alert-danger">Formato de fecha inválido.</div>
        <?php elseif ($err): ?>
            <div class="alert alert-danger">Error al procesar la cita. Intente de nuevo.</div>
        <?php endif; ?>

        <form method="POST" action="../controller/citas.php">
            <div class="mb-3">
                <label class="form-label">Cédula del Encargado</label>
                <input type="text" name="cedula_encargado" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Cédula del Niño</label>
                <input type="text" name="cedula_nino" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha y hora</label>
                <input type="text" name="fecha_cita" class="form-control" placeholder="Seleccione fecha y hora" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Motivo</label>
                <select name="motivo" class="form-select" required>
                    <option value="">Seleccione un motivo</option>
                    <option>Consulta de programas</option>
                    <option>Pagos</option>
                    <option>Información general</option>
                    <option>Reclamos</option>
                    <option>Otros</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Agendar Cita</button>
        </form>
    </div>
<?php endif; ?>

<?php if ($rol == 1): ?>
<div class="card mt-5 mb-5" style="max-width: 900px;">
    <h3 class="text-center mb-4" style="color: #20b2aa; font-weight: 600;">
        <i class="fas fa-calendar-check me-2"></i>Todas las citas programadas
    </h3>

    <?php if (empty($citas)): ?>
        <p class="text-center text-muted">No hay citas registradas.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light text-center">
                    <tr>
                        <th scope="col"><i class="fas fa-user"></i> Nombre</th>
                        <th scope="col"><i class="fas fa-calendar-day"></i> Fecha y hora</th>
                        <th scope="col"><i class="fas fa-question-circle"></i> Motivo</th>
                        <th scope="col"><i class="fas fa-info-circle"></i> Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $c): ?>
                        <tr class="text-center">
                            <td><?= htmlspecialchars($c["encargado"]) ?></td>
                            <td><?= htmlspecialchars($c["fecha_cita"]) ?></td>
                            <td><?= htmlspecialchars($c["motivo"]) ?></td>
                            <td>
                                <span class="badge bg-secondary px-3 py-2">
                                    <?= htmlspecialchars($c["estado"]) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>

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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr("input[name='fecha_cita']", {
    enableTime: true,
    dateFormat: "d/m/Y H:i",
    minDate: "today",
    time_24hr: true,
    locale: {
        firstDayOfWeek: 1
    }
});
</script>
</body>
</html>