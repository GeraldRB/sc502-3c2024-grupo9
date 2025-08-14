<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preguntas Frecuentes | Guardería</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

  <style>
    body {
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

    .faq-search {
      max-width: 820px;
      margin: 12px auto 25px;
    }

    .accordion {
      max-width: 900px;
      margin: 0 auto 40px;
    }

    .accordion-item {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
      margin-bottom: 12px;
    }

    .accordion-button:focus {
      box-shadow: none;
    }

    .accordion-button:not(.collapsed) {
      background: #e8f7f6;
      color: #0f6f6a;
    }

    footer {
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

  <?php
  session_start();
  $rol = $_SESSION['id_rol'] ?? null;
  ?>

  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand" href="index.php">
      <img src="../public/logo.jpg" alt="REDCUDI Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a
            class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'recomendaciones.php' ? ' active' : '' ?>"
            href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a
            class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'matricula.php' ? ' active' : '' ?>"
            href="matricula.php">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'faqs.php' ? ' active' : '' ?>"
            href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'citas.php' ? ' active' : '' ?>"
            href="citas.php">Citas</a></li>
        <?php if ($rol != 2): ?>
          <li class="nav-item"><a
              class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'programas.php' ? ' active' : '' ?>"
              href="programas.php">Programas Educativos</a></li>
          <li class="nav-item"><a
              class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'tablas/listaProgramas.php' ? ' active' : '' ?>"
              href="tablas/listaProgramas.php">Lista de Programas</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link<?= basename($_SERVER['PHP_SELF']) == 'contacto.php' ? ' active' : '' ?>"
            href="contacto.php">Contacto</a></li>
      </ul>
    </div>
  </nav>


  <section class="page-header container">
    <h1>Preguntas <span class="brand-accent">Frecuentes</span></h1>
    <p>Resolvemos dudas sobre matrícula, horarios, pagos, salud, seguridad y más.</p>
  </section>

  <div class="faq-search px-3">
    <input id="searchFaq" type="text" class="form-control form-control-lg"
      placeholder="Buscar preguntas (ej. matrícula, horarios, pagos)…">
  </div>

  <div class="container">
    <div class="accordion" id="faqs">
    </div>
  </div>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I.</p>
    <p><strong>Provincia:</strong> San José, Cantón: San José, Distrito: Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba, lote detrás del Play, contiguo a iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2222-7772</p>
    <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script>
    const faqs = [
      ["fas fa-child text-primary", "¿Cómo puedo inscribir a mi hijo/a?", "Completá el formulario de inscripción en línea o visitanos para apoyo presencial."],
      ["fa-regular fa-clock text-info", "¿Cuáles son los horarios de atención?", "Lunes a viernes, de 7:00 a.m. a 6:00 p.m. En feriados seguimos el calendario del MEP/REDCUDI."],
      ["fas fa-folder-open text-secondary", "¿Qué documentos necesito para la inscripción?", "Copia de cédula del encargado, certificado de nacimiento, carnet de vacunas al día, certificado médico reciente y formulario de inscripción completo."],
      ["fas fa-bowl-food text-warning", "¿La guardería brinda alimentación?", "Sí. Ofrecemos desayuno, merienda y almuerzo. Si hay alergias, adaptamos la dieta con certificado médico."],
      ["fas fa-child-reaching text-primary", "¿Qué edades aceptan?", "Desde 6 meses hasta 6 años. Organizamos grupos por edad y nivel de desarrollo."],
      ["fas fa-hand-holding-dollar text-success", "¿Qué métodos de pago aceptan?", "Transferencia, tarjeta y efectivo. Se paga en los primeros 5 días hábiles del mes. Consultá por becas."],
      ["fas fa-notes-medical text-danger", "¿Qué pasa si el niño presenta síntomas?", "Si hay fiebre o síntomas contagiosos, pedimos mantenerlo en casa. Medicación solo con receta y autorización escrita."],
      ["fas fa-right-to-bracket text-secondary", "¿Cómo es el ingreso y retiro?", "Solo personas autorizadas pueden retirar al menor. Solicitamos identificación siempre."],
      ["fas fa-people-roof text-info", "¿Cómo apoyan la adaptación?", "Realizamos un periodo de adaptación progresivo, con acompañamiento de los padres."],
      ["fas fa-comments text-success", "¿Cómo se comunican con las familias?", "Por reuniones, informes mensuales, WhatsApp y correo institucional."],
      ["fas fa-box-open text-warning", "¿Qué materiales deben traer?", "Mochila rotulada, muda de ropa, pañales, toallitas y botella de agua. El resto se informa por nivel."],
      ["fas fa-calendar-check text-primary", "¿Puedo agendar una visita?", "Sí, agendando previamente para coordinar horarios y disponibilidad."],
      ["fas fa-shirt text-danger", "¿Hay uniforme o código de vestimenta?", "No es obligatorio, pero recomendamos ropa cómoda y segura para el juego."],
      ["fas fa-envelope text-secondary", "¿Cómo puedo contactarlos?", "Tel: 2222-7772, Correo: ministeriodelamisericordia2017@gmail.com o en nuestra sección de contacto."]
    ];

    const container = document.getElementById("faqs");
    faqs.forEach((faq, i) => {
      const item = document.createElement("div");
      item.className = "accordion-item";
      item.innerHTML = `
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#faq${i}">
            <i class="${faq[0]} me-2"></i> ${faq[1]}
          </button>
        </h2>
        <div id="faq${i}" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            ${faq[2]}
          </div>
        </div>
      `;
      container.appendChild(item);
    });

    document.getElementById("searchFaq").addEventListener("input", function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll(".accordion-item").forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(term) ? "" : "none";
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>