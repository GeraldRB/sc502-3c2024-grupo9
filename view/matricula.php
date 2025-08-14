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
<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require_once("../accesoDatos/conexion.php");

$listaProgramas = [];
$listaNinos = [];

try {
  $conexionBD = abrirConexion();

  $stmtP = $conexionBD->prepare("SELECT id_programa, titulo FROM programas_educativos WHERE estado = 1 ORDER BY titulo");
  $stmtP->execute();

  $rs = $stmtP->get_result();

  $listaProgramas = $rs->fetch_all(MYSQLI_ASSOC);
  $stmtP->close();

  $stmtN = $conexionBD->prepare("SELECT id_nino, nombre, fecha_nacimiento FROM ninos WHERE id_usuario_padre = ? ORDER BY nombre");
  $stmtN->bind_param("i", $usuarioID);

  $stmtN->execute();
  $rsN = $stmtN->get_result();

  $listaNinos = $rsN->fetch_all(MYSQLI_ASSOC);
  $stmtN->close();


} catch (Exception $e) {
}



  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nino     = (int) ($_POST["id_nino"] ?? 0);
    $programa = (int) ($_POST["programa"] ?? 0);
    $fecha    = trim($_POST["fecha"] ?? date('Y-m-d'));

    if ($nino <= 0 || $programa <= 0 || $fecha === '') {
      header("Location: ./matricula.php?error=" . urlencode("Datos incompletos"));
      exit;
    }

    $sql = "INSERT INTO matricula (id_nino, id_programa, fecha_matricula)
            VALUES (?, ?, ?)";
    $stmtt = $conexionBD->prepare($sql);
    $stmtt->bind_param("iis", $nino, $programa, $fecha);
    $stmtt->execute();
    $stmtt->close();


    $conexionBD->close();
    header("Location: ./matricula.php?success=1");
    exit;
  }


  $conexionBD->close();




?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Formulario de Matrícula</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    .navbar {
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand img {
      height: 50px;
    }

    main {
      flex: 1;
      background: url("../public/backgrand2.jpg") center center/cover no-repeat;
      background-size: 100%;
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

    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f9ff;
      height: 100vh;
    }

    .card {
      padding: 2rem;
      margin-top: 3px;
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


  <main class="shadow">
    <div class="card shadow">
      <img src="../public/logo.jpg" alt="REDCUDI Logo" class="logo">
      <div class="form-matricula">
        <h3 class="mb-4 text-center">Formulario de Matrícula</h3>
        <form method="POST">

          <div class="mb-3">
            <label for="id_nino" class="form-label">Nombre del Niño</label>
            <select class="form-select" id="id_nino" name="id_nino" required>
              <option value="" selected disabled>Seleccione al niño...</option>
              <?php foreach ($listaNinos as $n): ?>
                <option value="<?= (int) $n['id_nino'] ?>">
                  <?= htmlspecialchars($n['nombre']) ?> (<?= htmlspecialchars($n['fecha_nacimiento']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="id_programa" class="form-label">Programa</label>
            <select class="form-select" id="id_programa" name="programa" required>
              <option value="" selected disabled>Seleccione un programa...</option>
              <?php foreach ($listaProgramas as $p): ?>
                <option value="<?= htmlspecialchars($p['id_programa']) ?>">
                  <?= htmlspecialchars($p['titulo']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="fecha_matricula" class="form-label">Fecha de Matrícula</label>
            <input type="date" class="form-control" id="fecha_matricula" name="fecha" required>
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

  <script src="programa.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>