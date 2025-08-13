<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Padres | Guardería</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body{font-family:'Poppins',sans-serif; margin:0; min-height:100vh; display:flex; flex-direction:column;}
    .navbar{background:#fff; box-shadow:0 4px 6px rgba(0,0,0,.05);}
    .navbar-brand img{height:50px;}
    .hero{flex:1; display:flex; align-items:center; justify-content:center; padding:40px 12px;
      background:url("../public/guarderia.png") center/cover no-repeat; position:relative;}
    .hero::before{content:""; position:absolute; inset:0; background:rgba(255,255,255,.75);}
    .card-float{ position:relative; z-index:2; width:100%; max-width:680px; border-radius:14px; }
    footer{background:#20b2aa; color:#fff; text-align:center; padding:14px;}
    .subtitle{ color:#666; font-size:.95rem; }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg px-4">
    <a class="navbar-brand" href="index.php"><img src="../public/logo.jpg" alt="REDCUDI"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="matricula.html">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.html">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link active" href="padres.php">Padres</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.html">Contacto</a></li>
      </ul>
    </div>
  </nav>

  <section class="hero">
    <div class="card card-float p-4 shadow">
      <div class="text-center mb-2"><img src="../public/logo.jpg" alt="REDCUDI" style="height:60px"></div>
      <h3 class="text-center mb-1">Registro de Padre y Niño</h3>
      <p class="text-center subtitle mb-3">Se registra (o reutiliza) el padre y se liga el niño al <em>id_usuario</em> del padre.</p>

      <?php if (isset($_GET["ok"])): ?>
        <div class="alert alert-success">Datos guardados correctamente.</div>
      <?php elseif (isset($_GET["err"])): ?>
        <?php
          $map = [
            "campos" => "Completá todos los campos.",
            "ex"     => "No se pudo completar el registro. Intentá de nuevo."
          ];
          $msg = $map[$_GET["err"]] ?? "Error.";
        ?>
        <div class="alert alert-danger"><?php echo $msg; ?></div>
      <?php endif; ?>

      <form method="POST" action="../controller/padres.php">
        <div class="row g-3">
          <div class="col-12"><h5 class="mb-0">Datos del Padre/Madre</h5><hr class="mt-1"></div>

          <div class="col-md-6">
            <label class="form-label" for="padre_nombre">Nombre completo</label>
            <input class="form-control" id="padre_nombre" name="padre_nombre" required>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="padre_correo">Correo electrónico</label>
            <input type="email" class="form-control" id="padre_correo" name="padre_correo" required>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="padre_contrasena">Contraseña</label>
            <input type="password" class="form-control" id="padre_contrasena" name="padre_contrasena" required>
          </div>

          <div class="col-12 mt-2"><h5 class="mb-0">Datos del Niño</h5><hr class="mt-1"></div>

          <div class="col-md-6">
            <label class="form-label" for="nino_nombre">Nombre del niño</label>
            <input class="form-control" id="nino_nombre" name="nino_nombre" required>
          </div>
          <div class="col-md-6">
            <label class="form-label" for="nino_nacimiento">Fecha de nacimiento</label>
            <input type="date" class="form-control" id="nino_nacimiento" name="nino_nacimiento" required>
          </div>

          <div class="col-12">
            <button class="btn btn-primary w-100 mt-2" type="submit">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- Listado de verificación (últimos niños) -->
  <div class="container my-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">Últimos niños registrados</h5>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead class="table-dark">
              <tr>
                <th>ID Niño</th>
                <th>Nombre Niño</th>
                <th>Nacimiento</th>
                <th>ID Padre</th>
                <th>Padre/Madre</th>
                <th>Correo</th>
              </tr>
            </thead>
            <tbody>
              <?php
                require_once("../accesoDatos/conexion.php");
                try{
                  $cn = abrirConexion();
                  $sql = "SELECT n.id_nino, n.nombre AS nom_nino, n.fecha_nacimiento,
                                 u.id_usuario, u.nombre AS nom_padre, u.correo
                          FROM NINOS n
                          JOIN USUARIOS u ON u.id_usuario = n.id_usuario_padre
                          ORDER BY n.id_nino DESC
                          LIMIT 15";
                  $rs = $cn->query($sql);
                  if ($rs->num_rows === 0) {
                    echo "<tr><td colspan='6'>No hay registros aún.</td></tr>";
                  } else {
                    while($r = $rs->fetch_assoc()){
                      echo "<tr>";
                      echo "<td>".$r['id_nino']."</td>";
                      echo "<td>".htmlspecialchars($r['nom_nino'])."</td>";
                      echo "<td>".$r['fecha_nacimiento']."</td>";
                      echo "<td>".$r['id_usuario']."</td>";
                      echo "<td>".htmlspecialchars($r['nom_padre'])."</td>";
                      echo "<td>".htmlspecialchars($r['correo'])."</td>";
                      echo "</tr>";
                    }
                  }
                } catch (Exception $e) {
                  echo "<tr><td colspan='6' class='text-danger'>No se pudo cargar el listado.</td></tr>";
                } finally {
                  if (isset($cn)) cerrarConexion($cn);
                }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I</p>
    <p><strong>Provincia:</strong> San José &nbsp; <strong>Cantón:</strong> San José &nbsp; <strong>Distrito:</strong> Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Play, contiguo a iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2227-7722 &nbsp; <strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
