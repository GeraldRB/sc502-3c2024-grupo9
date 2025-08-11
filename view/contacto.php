<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto | Guardería</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles/estilos.css">
  <style> body{font-family:'Poppins',sans-serif;background:#f7f9fb;} </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg px-4" style="background:#fff;box-shadow:0 4px 6px rgba(0,0,0,.05);">
    <a class="navbar-brand" href="index.php">
      <img src="../public/logo.jpg" alt="REDCUDI Logo" style="height:50px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
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

  <main class="container py-5">
    <section class="text-center mb-4">
      <h1 class="fw-bold">Contacto</h1>
      <p class="text-muted">Escribinos y te respondemos lo antes posible.</p>
      <?php if (isset($_GET["ok"])): ?>
        <div class="alert alert-success">Mensaje enviado correctamente.</div>
      <?php elseif (isset($_GET["err"])): ?>
        <div class="alert alert-danger">No se pudo enviar. Intenta de nuevo.</div>
      <?php endif; ?>
    </section>

    <div class="row g-4">
      <div class="col-lg-6">
        <div class="card p-4 shadow-sm">
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
      </div>

      <div class="col-lg-6">
        <div class="card p-4 shadow-sm">
          <h5 class="mb-3">Mensajes recientes</h5>
          <ul class="list-group">
            <?php
            require_once("../accesoDatos/conexion.php");
            try {
              $cn = abrirConexion();
              $rs = $cn->query("SELECT nombre, correo, mensaje, fecha_envio FROM CONTACTO ORDER BY id_contacto DESC LIMIT 10");
              if ($rs->num_rows === 0) {
                echo '<li class="list-group-item">Aún no hay mensajes.</li>';
              }
              while ($row = $rs->fetch_assoc()) {
                echo '<li class="list-group-item">';
                echo '<strong>'.htmlspecialchars($row["nombre"]).'</strong> ('.htmlspecialchars($row["correo"]).')<br>';
                echo nl2br(htmlspecialchars($row["mensaje"]));
                echo '<div class="text-muted small mt-1">'.$row["fecha_envio"].'</div>';
                echo '</li>';
              }
            } catch (Exception $e) {
              echo '<li class="list-group-item text-danger">No se pudieron cargar los mensajes.</li>';
            } finally {
              if (isset($cn)) cerrarConexion($cn);
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </main>

  <footer style="background:#20b2aa;color:#fff;padding:20px;text-align:center;">
    <p><strong>Modalidad:</strong> C.I.D.A.I</p>
    <p><strong>Provincia:</strong> San José &nbsp; <strong>Cantón:</strong> San José &nbsp; <strong>Distrito:</strong> Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Play, contiguo a iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2227-7722 &nbsp; <strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
