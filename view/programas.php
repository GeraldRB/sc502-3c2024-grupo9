<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
  header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
  exit;
}

$rol = $_SESSION['id_rol'];

$errores = isset($_GET['error']) ? explode('|', $_GET['error']) : [];
$ok = isset($_GET['success']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Programas Educativos</title>

  <link rel="stylesheet" href="Css/stilos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f9ff;
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
      background: url("../public/backgraund.jpg") center no-repeat;
      background-size: cover;
      min-height: 80vh;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    main::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 1;
    }

    main>* {
      position: relative;
      z-index: 2;
    }

    .card {
      padding: 2rem;
      width: 100%;
      max-width: 480px;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .logo {
      width: 150px;
      display: block;
      margin: 0 auto 1rem auto;
    }

    .btn-success {
      background-color: #20b2aa;
      border-color: #20b2aa;
    }

    .btn-success:hover {
      background-color: #198c85;
      border-color: #198c85;
    }

    footer {
      background-color: #20b2aa;
      color: white;
      padding: 12px 20px;
      text-align: center;
      font-size: 0.9rem;
    }

    footer p {
      margin: 3px 0;
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>

<body class="bg-light">

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


  <main class="shadow p-4">
    <div class="container py-4 d-flex flex-column align-items-center">
      <div class="text-center mb-4">
        <h1 class="fw-bold">Gestión de Programas Educativos</h1>
        <p class="lead">Agregá, editá o eliminá los programas ofrecidos por la guardería</p>
      </div>

      <div class="card p-4 shadow-lg mb-5 mx-auto">
        <form id="formPrograma" method="POST" action="../controller/programa.php">
          <input type="hidden" id="id_programa" name="id_programa" />

          <img src="../public/logo.jpg" alt="REDCUDI Logo" class="logo">

          <div class="mb-3">
            <label for="titulo" class="form-label">Título del Programa</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label for="nivel" class="form-label">Nivel</label>
            <input type="text" class="form-control" id="nivel" name="nivel" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
              <input type="date" class="form-control" id="fecha_inicio" name="fechaInicio" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="fecha_fin" class="form-label">Fecha de Fin</label>
              <input type="date" class="form-control" id="fecha_fin" name="fechaFin" required>
            </div>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="estado" id="estado" value="1">
            <label class="form-check-label" for="estado">Programa Activo</label>
          </div>

          <button type="submit" class="btn btn-success w-100">Guardar Programa</button>
        </form>
      </div>
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

  <script src="programa.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>