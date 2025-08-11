<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto | Guardería</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <style>
    body{font-family:'Poppins',sans-serif; margin:0; min-height:100vh; display:flex; flex-direction:column;}
    .navbar{background:#fff; box-shadow:0 4px 6px rgba(0,0,0,.05);}
    .navbar-brand img{height:50px;}
    .hero{flex:1; display:flex; align-items:center; justify-content:center; padding:40px 12px;
      background:url("../public/guarderia.png") center/cover no-repeat; position:relative;}
    .hero::before{content:""; position:absolute; inset:0; background:rgba(255,255,255,.75);}
    .card-float{ position:relative; z-index:2; width:100%; max-width:520px; border-radius:14px; }
    footer{background:#20b2aa; color:#fff; text-align:center; padding:14px;}
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand" href="index.php"><img src="../public/logo.jpg" alt="REDCUDI"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav"><span class="navbar-toggler-icon"></span></button>
    <div id="nav" class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="matricula.html">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
      </ul>
    </div>
  </nav>

  <section class="hero">
    <div class="card card-float p-4 shadow">
      <div class="text-center mb-2">
        <img src="../public/logo.jpg" alt="REDCUDI" style="height:60px">
      </div>
      <h3 class="text-center mb-3">Contacto</h3>

      <?php if (isset($_GET["ok"])): ?>
        <div class="alert alert-success">Mensaje enviado correctamente.</div>
      <?php elseif (isset($_GET["err"])): ?>
        <div class="alert alert-danger">No se pudo enviar. Intenta de nuevo.</div>
      <?php endif; ?>

      <form method="POST" action="../controller/contacto.php">
        <div class="mb-3">
          <label class="form-label" for="nombre">Nombre completo</label>
          <input class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="correo">Correo electrónico</label>
          <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="mensaje">Mensaje</label>
          <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
        </div>
        <button class="btn btn-primary w-100" type="submit">Enviar</button>
      </form>
    </div>
  </section>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I</p>
    <p><strong>Provincia:</strong> San José &nbsp; <strong>Cantón:</strong> San José &nbsp; <strong>Distrito:</strong> Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Play, contiguo a iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2227-7722 &nbsp; <strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
