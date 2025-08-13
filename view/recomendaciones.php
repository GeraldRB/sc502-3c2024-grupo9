<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Consejos y Recomendaciones | Guardería</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

  <style>
    html, body {
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
        <li class="nav-item"><a class="nav-link active" href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
      </ul>
    </div>
  </nav>

  <main>
    <section class="page-header container">
      <h1>Consejos y <span class="brand-accent">Recomendaciones</span></h1>
      <p>Estos son algunos de los consejos que <strong>Ministerio de la Misericordia</strong> tiene para ti.</p>
    </section>

    <div class="container">
      <div class="accordion" id="accordionExample">

        <!-- Recomendaciones en formato acordeón -->
        <?php
          $recomendaciones = [
            ["fas fa-baby text-primary", "Recomendaciones para el primer día", [
              "Qué llevar (ropa extra, pañales, biberones, etc.)",
              "Cómo preparar al niño emocionalmente",
              "Llegar con tiempo y calma",
              "No alargar las despedidas"
            ]],
            ["fas fa-heartbeat text-danger", "Recomendaciones de salud e higiene", [
              "Mantener al niño en casa si presenta fiebre o síntomas contagiosos",
              "Informar sobre alergias o medicamentos",
              "Llevar artículos personales marcados con su nombre"
            ]],
            ["fas fa-utensils text-warning", "Recomendaciones para la alimentación", [
              "Si se permite traer comida de casa: sugerencias saludables",
              "Carné de vacunas al día",
              "Certificado médico reciente",
              "Formulario de inscripción completo"
            ]],
            ["fas fa-users text-info", "Recomendaciones generales para padres", [
              "Fomentar rutinas en casa",
              "Leer juntos antes de dormir",
              "Ser pacientes con los cambios de conducta",
              "Participar en actividades escolares o reuniones"
            ]],
            ["fas fa-comments text-success", "Recomendaciones para una buena comunicación", [
              "Mantener contacto constante con los educadores",
              "Revisar diariamente el cuaderno o app de comunicación",
              "Informar cualquier cambio familiar importante"
            ]],
            ["fas fa-child text-primary", "Consejos para la adaptación de los niños", [
              "Explicar con anticipación que irá a la guardería",
              "Visitar el lugar antes del primer día",
              "Enviar un objeto que le dé seguridad (peluche, mantita)",
              "Ser paciente en el proceso de adaptación"
            ]],
            ["fas fa-book-reader text-secondary", "Actividades para reforzar el aprendizaje en casa", [
              "Leer un cuento todos los días",
              "Jugar con bloques y rompecabezas",
              "Dibujar y colorear juntos",
              "Realizar juegos que estimulen la memoria"
            ]],
            ["fas fa-shield-alt text-danger", "Seguridad en el centro educativo", [
              "Ingresar y salir solo con autorización previa",
              "Presentar carnet de retiro al entrar",
              "No dejar objetos peligrosos en mochilas"
            ]],
            ["fas fa-calendar-alt text-warning", "Participación en eventos escolares", [
              "Asistir a las reuniones de padres",
              "Participar en celebraciones y actividades especiales",
              "Proporcionar apoyo en excursiones",
              "Colaborar con materiales cuando sea necesario"
            ]],
            ["fas fa-bed text-info", "Consejos para un descanso saludable", [
              "Mantener un horario fijo para dormir",
              "Evitar pantallas antes de acostarse",
              "Crear un ambiente relajado y sin ruidos",
              "Usar pijama cómoda y apropiada para el clima"
            ]]
          ];

          foreach ($recomendaciones as $index => [$icono, $titulo, $items]) {
            echo <<<HTML
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#rec$index">
                  <i class="$icono me-2"></i> $titulo
                </button>
              </h2>
              <div id="rec$index" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  • {implode("<br>• ", $items)}
                </div>
              </div>
            </div>
            HTML;
          }
        ?>
      </div>
    </div>
  </main>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I</p>
    <p><strong>Provincia:</strong> San José &nbsp; <strong>Cantón:</strong> San José &nbsp; <strong>Distrito:</strong> Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Play, contiguo a iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2227-7722</p>
    <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>