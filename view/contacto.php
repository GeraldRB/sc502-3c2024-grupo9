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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
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

    h1, h2 {
      color: #20b2aa;
      font-weight: 600;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .btn-primary {
      background-color: #20b2aa;
      border-color: #20b2aa;
    }

    .btn-primary:hover {
      background-color: #1d9797;
    }

    .list-group-item {
      border-radius: 0.5rem;
      margin-bottom: 10px;
      box-shadow: 0 1px 5px rgba(0,0,0,.05);
    }

    .text-muted {
      font-size: 0.85rem;
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
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
          <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'recomendaciones.php' ? ' active' : '' ?>" href="recomendaciones.php">Recomendaciones</a></li>
          <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'matricula.php' ? ' active' : '' ?>" href="matricula.php">Matrícula</a></li>
          <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'faqs.php' ? ' active' : '' ?>" href="faqs.php">FAQs</a></li>
          <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'citas.php' ? ' active' : '' ?>" href="citas.php">Citas</a></li>
          <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
        <?php endif; ?>
        <?php if ($rol == 1): ?>
          <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'programas.php' ? ' active' : '' ?>" href="programas.php">Programas Educativos</a></li>
          <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'listaProgramas.php' ? ' active' : '' ?>" href="tablas/listaProgramas.php">Lista de Programas</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>

  <!-- CONTENIDO -->
  <div class="container py-5">
    <div class="text-center mb-4">
      <h1>Contacto</h1>
      <p class="lead">Envíanos tus consultas o comentarios y te responderemos pronto.</p>
    </div>

    <?php if (isset($_GET["ok"])): ?>
      <div class="alert alert-success text-center">Mensaje enviado correctamente.</div>
    <?php elseif (isset($_GET["err"])): ?>
      <div class="alert alert-danger text-center">No se pudo enviar. Intenta de nuevo.</div>
    <?php endif; ?>

    <!-- FORMULARIO -->
    <div class="card p-4 mb-5">
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

    <!-- MENSAJES RECIBIDOS -->
    <div class="mt-5">
      <h2 class="text-center mb-4">Mensajes Recibidos</h2>
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
          <span class="badge bg-light text-dark ms-2"><?= htmlspecialchars($row["correo"]) ?></span>
          <p class="mb-1 mt-2"><?= nl2br(htmlspecialchars($row["mensaje"])) ?></p>
          <div class="text-muted">Enviado: <?= $row["fecha_envio"] ?></div>
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