<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
    header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
    exit;
}

$rol = $_SESSION['id_rol'];
$usuarioID = $_SESSION['usuarioID'];

$errores = isset($_GET['error']) ? explode('|', $_GET['error']) : [];
$ok = isset($_GET['success']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/estilos.css">
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
  </style>
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand" href="index.php">
      <img src="../public/logo.jpg" alt="Logo Guardería">
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
          <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
          <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
        <?php if ($rol == 1): ?>
          <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
          <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <div class="container py-5">
    <div class="text-center mb-4">
      <h1 class="fw-bold">Contacto</h1>
      <p class="lead">Envíanos tus consultas o comentarios y te respondemos pronto.</p>

      <?php if (isset($_GET["ok"])): ?>
        <div class="alert alert-success">Mensaje enviado correctamente.</div>
      <?php elseif (isset($_GET["err"])): ?>
        <div class="alert alert-danger">No se pudo enviar. Intenta de nuevo.</div>
      <?php endif; ?>
    </div>

    <div class="card p-4 shadow-lg mb-5">
      <form method="POST" action="../controller/contacto.php">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre completo</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label> 
          <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <div class="mb-3">
          <label for="mensaje" class="form-label">Mensaje</label>
          <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Enviar mensaje</button>
      </form>
    </div>

    <div class="mt-5">
      <h2 class="fw-bold text-center mb-3">Mensajes recibidos</h2>
      <ul class="list-group">
        <?php
          require_once("../accesoDatos/conexion.php");
          try {
            $cn = abrirConexion();
            $rs = $cn->query("SELECT nombre, correo, mensaje, fecha_envio FROM CONTACTO ORDER BY id_contacto DESC LIMIT 20");
            while ($row = $rs->fetch_assoc()):
        ?>
          <li class="list-group-item">
            <strong><?= htmlspecialchars($row["nombre"]) ?></strong>
            (<em><?= htmlspecialchars($row["correo"]) ?></em>)<br>
            <?= nl2br(htmlspecialchars($row["mensaje"])) ?>
            <div class="text-muted small">Enviado: <?= $row["fecha_envio"] ?></div>
          </li>
        <?php
            endwhile;
          } catch (Exception $e) {
            echo '<li class="list-group-item text-danger">No se pudieron cargar los mensajes.</li>';
          } finally {
            if (isset($cn)) cerrarConexion($cn);
          }
        ?>
      </ul>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
