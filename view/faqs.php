<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Preguntas Frecuentes | Guardería</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

  <style>
    body{ font-family:'Poppins',sans-serif; background:#f7f9fb; }
    .navbar{ background:#fff; box-shadow:0 4px 6px rgba(0,0,0,.05); }
    .navbar-brand img{ height:50px; }

    .page-header{ padding:40px 0 10px; text-align:center; }
    .page-header h1{ font-weight:700; margin-bottom:.5rem; }
    .page-header p{ color:#666; margin:0; }
    .brand-accent{ color:#20b2aa; }

    .faq-search{ max-width:820px; margin: 12px auto 25px; }

    .accordion{ max-width: 900px; margin: 0 auto 40px; }
    .accordion-item{ border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,.05); margin-bottom:12px; }
    .accordion-button:focus{ box-shadow:none; }
    .accordion-button:not(.collapsed){ background:#e8f7f6; color:#0f6f6a; }

    footer{ background:#20b2aa; color:#fff; padding:20px; text-align:center; }
    footer p{ margin:4px 0; font-size:.95rem; }
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
        <li class="nav-item"><a class="nav-link" href="matricula.html">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.html">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="programa.html">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.html">Contacto</a></li>
      </ul>
    </div>
  </nav>

  <section class="page-header container">
    <h1>Preguntas <span class="brand-accent">Frecuentes</span></h1>
    <p>Resolvemos dudas sobre matrícula, horarios, pagos, salud, seguridad y más.</p>
  </section>

  <div class="faq-search px-3">
    <input id="searchFaq" type="text" class="form-control form-control-lg" placeholder="Buscar preguntas (ej. matrícula, horarios, pagos)…">
  </div>

  <div class="container">
    <div class="accordion" id="faqs">

      <div class="accordion-item" data-keywords="matricula inscripcion requisitos formulario">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q1">
            <i class="fa-solid fa-file-circle-check me-2 text-primary"></i> ¿Cómo puedo inscribir a mi hijo/a?
          </button>
        </h2>
        <div id="q1" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Completá el formulario de inscripción en línea o visitanos para apoyo presencial.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="horarios atencion entrada salida feriados">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q2">
            <i class="fa-regular fa-clock me-2 text-info"></i> ¿Cuáles son los horarios de atención?
          </button>
        </h2>
        <div id="q2" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Lunes a viernes, de 7:00 a.m. a 6:00 p.m. En feriados seguimos el calendario del MEP/REDCUDI.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="documentos requisitos cedula certificado nacimiento vacunas medico">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q3">
            <i class="fa-solid fa-folder-open me-2 text-secondary"></i> ¿Qué documentos necesito para la inscripción?
          </button>
        </h2>
        <div id="q3" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Copia de cédula del encargado, certificado de nacimiento, carné de vacunas al día, certificado médico reciente y formulario de inscripción completo.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="alimentacion menu alergias colacion">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q4">
            <i class="fa-solid fa-bowl-food me-2 text-warning"></i> ¿La guardería brinda alimentación?
          </button>
        </h2>
        <div id="q4" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Sí. Ofrecemos desayuno, merienda y almuerzo con menú balanceado. Si hay alergias, presentá certificado médico y adaptamos la dieta.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="edad admision lactantes maternal preescolar">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q5">
            <i class="fa-solid fa-child-reaching me-2 text-primary"></i> ¿Qué edades aceptan?
          </button>
        </h2>
        <div id="q5" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Desde 6 meses hasta 6 años. Organizamos grupos por edad y nivel de desarrollo.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="pagos mensualidad metodos transferencia tarjeta efectivo becas">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q6">
            <i class="fa-solid fa-hand-holding-dollar me-2 text-success"></i> ¿Qué métodos de pago aceptan?
          </button>
        </h2>
        <div id="q6" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Transferencia, tarjeta y efectivo. La mensualidad se cancela en los primeros 5 días hábiles del mes. Consultá por opciones de beca.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="salud fiebre sintomas medicamentos protocolo">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q7">
            <i class="fa-solid fa-notes-medical me-2 text-danger"></i> ¿Qué pasa si el niño presenta síntomas?
          </button>
        </h2>
        <div id="q7" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Si hay fiebre o síntomas contagiosos, pedimos mantenerlo en casa. Para medicación en el centro requerimos receta y autorización escrita.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="ingreso salida seguridad protocolo">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q8">
            <i class="fa-solid fa-right-to-bracket me-2 text-secondary"></i> ¿Cómo es el ingreso y retiro?
          </button>
        </h2>
        <div id="q8" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Solo personas autorizadas pueden retirar al menor. Solicitamos identificación siempre.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="adaptacion proceso apoyo emocional">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q9">
            <i class="fa-solid fa-people-roof me-2 text-info"></i> ¿Cómo apoyan la adaptación?
          </button>
        </h2>
        <div id="q9" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Realizamos un periodo de adaptación progresivo, con acompañamiento de los padres según necesidad.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="comunicacion padres informes whatsapp">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q10">
            <i class="fa-solid fa-comments me-2 text-success"></i> ¿Cómo se comunican con las familias?
          </button>
        </h2>
        <div id="q10" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Por reuniones, informes mensuales, y canales como WhatsApp y correo institucional.
          </div>
        </div>
      </div>

        <div class="accordion-item" data-keywords="materiales uniforme mochila rotular lista utiles">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q11">
                    <i class="fa-solid fa-box-open me-2 text-warning"></i> ¿Qué materiales deben traer?
                </button>
        </h2>
        <div id="q11" class="accordion-collapse collapse" data-bs-parent="#faqs">
            <div class="accordion-body">
              Mochila rotulada, muda de ropa, pañales (si usa), toallitas y botella de agua. El resto se informa por nivel al inicio de periodo.
            </div>
            </div>
        </div>

      <div class="accordion-item" data-keywords="visitas recorrido instalaciones">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q12">
            <i class="fa-solid fa-calendar-check me-2 text-primary"></i> ¿Puedo agendar una visita?
          </button>
        </h2>
        <div id="q12" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Sí, agendando previamente para coordinar horarios y garantizar disponibilidad.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="uniforme vestimenta codigo ropa">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q13">
            <i class="fa-solid fa-shirt me-2 text-danger"></i> ¿Hay uniforme o código de vestimenta?
          </button>
        </h2>
        <div id="q13" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            No hay uniforme obligatorio, pero recomendamos ropa cómoda y segura para el juego.
          </div>
        </div>
      </div>

      <div class="accordion-item" data-keywords="contacto direccion telefono correo">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#q14">
            <i class="fa-solid fa-envelope me-2 text-secondary"></i> ¿Cómo puedo contactarlos?
          </button>
        </h2>
        <div id="q14" class="accordion-collapse collapse" data-bs-parent="#faqs">
          <div class="accordion-body">
            Tel: 2222-7772, Correo: ministeriodelamisericordia2017@gmail.com o en nuestra sección de contacto.
          </div>
        </div>
      </div>

    </div>
  </div>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I.</p>
    <p><strong>Provincia:</strong> San José, Cantón: San José, Distrito: Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba, lote detrás del Play, contiguo a iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2222-7772</p>
    <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById("searchFaq").addEventListener("input", function() {
      let term = this.value.toLowerCase();
      document.querySelectorAll(".accordion-item").forEach(item => {
        let keywords = item.getAttribute("data-keywords");
        if(keywords && keywords.toLowerCase().includes(term)){
          item.style.display = "";
        } else {
          item.style.display = term === "" ? "" : "none";
        }
      });
    });
  </script>
</body>
</html>