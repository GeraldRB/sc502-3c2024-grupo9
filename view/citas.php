<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
  header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
  exit;
}

$rol = $_SESSION['id_rol'];

require_once("../accesoDatos/conexion.php");
$cn = abrirConexion();

// Obtener citas con nombre del usuario
$sql = "SELECT citas.*, usuarios.nombre 
        FROM citas
        INNER JOIN usuarios ON citas.id_usuario = usuarios.id_usuario
        ORDER BY fecha_cita DESC";
$resultado = $cn->query($sql);

$citas = [];
while ($row = $resultado->fetch_assoc()) {
  $citas[] = $row;
}

cerrarConexion($cn);
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Citas | Guardería</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: #eaf7ff;
    }

    .navbar {
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand img {
      height: 50px;
    }

    main {
      flex: 1;
      padding: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      width: 100%;
      max-width: 900px;
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 2rem;
    }

    h3 {
      color: #20b2aa;
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
    }

    th {
      background-color: #e6f7f5;
    }

    .table td, .table th {
      vertical-align: middle;
    }

    footer {
      background-color: #20b2aa;
      color: white;
      text-align: center;
      font-size: 0.9rem;
      padding: 15px 20px;
    }

    footer p {
      margin: 3px 0;
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
          <li class="nav-item"><a class="nav-link active" href="citas.php">Citas</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
        <?php if ($rol == 1): ?>
          <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
          <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
          <li class="nav-item"><a class="nav-link" href="usuarios/listaUsuarios.php">Lista de Usuarios</a></li>
        <?php endif; ?>
        <?php if ($rol == 3): ?>
          <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
          <li class="nav-item"><a class="nav-link active" href="citas.php">Citas</a></li>
          <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <main>
    <div class="card">
      <h3>Citas Programadas</h3>
      <?php if (empty($citas)): ?>
        <p class="text-muted text-center">No hay citas registradas aún.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-bordered mt-3">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Fecha</th>
                <th>Motivo</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($citas as $cita): ?>
                <tr>
                  <td><?= htmlspecialchars($cita["nombre"]) ?></td>
                  <td><?= htmlspecialchars($cita["fecha_cita"]) ?></td>
                  <td><?= htmlspecialchars($cita["motivo"]) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <footer class="mt-auto">
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
