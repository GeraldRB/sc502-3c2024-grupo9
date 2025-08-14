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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Consejos y Recomendaciones | Guardería</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <style>
    html,
    body {
      height: 100%;
    }

    body {
      margin: 0;
      display: flex;
      flex-direction: column;
      font-family: 'Poppins', sans-serif;
      background: #f7f9fb;
    }

    .navbar {
      background: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, .05);
    }

    .navbar-brand img {
      height: 50px;
    }

    main {
      flex: 1;
    }

    .page-header {
      padding: 40px 0 10px;
      text-align: center;
    }

    .page-header h1 {
      font-weight: 700;
      margin-bottom: .5rem;
    }

    .page-header p {
      color: #666;
      margin: 0;
    }

    .brand-accent {
      color: #20b2aa;
    }

    .accordion {
      max-width: 720px;
      margin: 0 auto 40px;
    }

    .accordion-button:focus {
      box-shadow: none;
    }

    .accordion-button:not(.collapsed) {
      background: #e8f7f6;
      color: #0f6f6a;
    }

    .accordion-item {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
      margin-bottom: 12px;
    }

    footer {
      margin-top: auto;
      background: #20b2aa;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    footer p {
      margin: 4px 0;
      font-size: .95rem;
    }
  </style>
</head>

<body>

<nav class="navbar navbar-expand-lg px-4">
  <a class="navbar-brand" href="index.php">
    <img src="../public/logo.jpg" alt="REDCUDI Logo">
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div id="nav" class="collapse navbar-collapse justify-content-end">
    <ul class="navbar-nav">
      <?php if ($rol == 1):?>
        <li class="nav-item"><a class="nav-link active" href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>

      <?php elseif ($rol == 2):?>
        <li class="nav-item"><a class="nav-link active" href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>

      <?php elseif ($rol == 3):?>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

  <main>
    <section class="page-header container">
      <h1>Consejos y <span class="brand-accent">Recomendaciones</span></h1>
      <p>Estos son algunos de los consejos que <strong>Ministerio de la Misericordia</strong> tiene para ti.</p>
    </section>

    <div class="container">
      <div class="accordion" id="accordionRecomendaciones">

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec0">
              <i class="fas fa-baby me-2 text-primary"></i> Recomendaciones para el primer día
            </button>
          </h2>
          <div id="rec0" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Qué llevar (ropa extra, pañales, biberones, etc.)<br>
              Cómo preparar al niño emocionalmente<br>
              Llegar con tiempo y calma<br>
              No alargar las despedidas
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec1">
              <i class="fas fa-heartbeat me-2 text-danger"></i> Recomendaciones de salud e higiene
            </button>
          </h2>
          <div id="rec1" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Mantener al niño en casa si presenta fiebre o síntomas<br>
              Informar sobre alergias o medicamentos<br>
              Llevar artículos personales marcados
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec2">
              <i class="fas fa-utensils me-2 text-warning"></i> Recomendaciones para la alimentación
            </button>
          </h2>
          <div id="rec2" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Sugerencias saludables para refrigerios<br>
              Carné de vacunas al día<br>
              Certificado médico reciente
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec3">
              <i class="fas fa-people-roof me-2 text-info"></i> Recomendaciones generales para padres
            </button>
          </h2>
          <div id="rec3" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Fomentar rutinas en casa<br>
              Leer juntos antes de dormir<br>
              Participar en actividades escolares
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec4">
              <i class="fas fa-comments me-2 text-success"></i> Recomendaciones para una buena comunicación
            </button>
          </h2>
          <div id="rec4" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Contacto constante con los educadores<br>
              Revisar cuadernos o apps de comunicación<br>
              Avisar sobre cambios importantes en casa
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec5">
              <i class="fas fa-child me-2 text-primary"></i> Consejos para la adaptación de los niños
            </button>
          </h2>
          <div id="rec5" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Explicar con anticipación que irá a la guardería<br>
              Visitar el lugar antes del primer día<br>
              Enviar un objeto que le dé seguridad (peluche, mantita)<br>
              Ser paciente en el proceso de adaptación
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec6">
              <i class="fas fa-book-reader me-2 text-secondary"></i> Actividades para reforzar el aprendizaje en casa
            </button>
          </h2>
          <div id="rec6" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Leer un cuento todos los días<br>
              Jugar con bloques y rompecabezas<br>
              Dibujar y colorear juntos<br>
              Realizar juegos que estimulen la memoria
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec7">
              <i class="fas fa-shield-alt me-2 text-danger"></i> Seguridad en el centro educativo
            </button>
          </h2>
          <div id="rec7" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Ingresar y salir solo con autorización previa<br>
              Presentar carnet de retiro al entrar<br>
              No dejar objetos peligrosos en mochilas
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec8">
              <i class="fas fa-calendar-alt me-2 text-warning"></i> Participación en eventos escolares
            </button>
          </h2>
          <div id="rec8" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Asistir a las reuniones de padres<br>
              Participar en celebraciones y actividades especiales<br>
              Proporcionar apoyo en excursiones<br>
              Colaborar con materiales cuando sea necesario
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec9">
              <i class="fas fa-bed me-2 text-info"></i> Consejos para un descanso saludable
            </button>
          </h2>
          <div id="rec9" class="accordion-collapse collapse" data-bs-parent="#accordionRecomendaciones">
            <div class="accordion-body">
              Mantener un horario fijo para dormir<br>
              Evitar pantallas antes de acostarse<br>
              Crear un ambiente relajado y sin ruidos<br>
              Usar pijama cómoda y apropiada para el clima
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I</p>
    <p><strong>Provincia:</strong> San José &nbsp; <strong>Cantón:</strong> San José &nbsp; <strong>Distrito:</strong>
      Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Palí, contiguo a la Iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2227-7702</p>
    <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>