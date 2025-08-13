<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Citas | Guardería</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

  <style>
    body{font-family:'Poppins',sans-serif; margin:0; min-height:100vh; display:flex; flex-direction:column;}
    .navbar{background:#fff; box-shadow:0 4px 6px rgba(0,0,0,.05);}
    .navbar-brand img{height:50px;}
    .hero{
      flex:1; display:flex; align-items:center; justify-content:center; padding:40px 12px;
      background:url("../public/guarderia.png") center/cover no-repeat; position:relative;
    }
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
        <li class="nav-item"><a class="nav-link active" href="citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="padres.php">Padres</a></li>
      </ul>
    </div>
  </nav>

  <section class="hero">
    <div class="card card-float p-4 shadow">
      <div class="text-center mb-2">
        <img src="../public/logo.jpg" alt="REDCUDI" style="height:60px">
      </div>
      <h3 class="text-center mb-3">Agendar Cita</h3>

      <?php if (isset($_GET["ok"])): ?>
        <div class="alert alert-success">Cita creada correctamente.</div>
      <?php elseif (isset($_GET["err"])): 
        $map=["campos"=>"Completá todos los campos.","pasado"=>"La fecha/hora debe ser futura.","choque"=>"Ya tenés una cita en esa fecha/hora.","ins"=>"No se pudo guardar la cita.","ex"=>"Error inesperado."];
        $msg=$map[$_GET["err"]] ?? "Error.";
      ?>
        <div class="alert alert-danger"><?php echo $msg; ?></div>
      <?php endif; ?>

      <form method="POST" action="../controller/citas.php">
        <div class="mb-3">
          <label class="form-label" for="cedula_encargado">Cédula del Encargado</label>
          <input class="form-control" id="cedula_encargado" name="cedula_encargado" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="cedula_nino">Cédula del Niño</label>
          <input class="form-control" id="cedula_nino" name="cedula_nino" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="fecha_cita">Fecha y hora</label>
          <input class="form-control" id="fecha_cita" name="fecha_cita" placeholder="mm/dd/yyyy --:--" required>
        </div>
        <div class="mb-3">
          <label class="form-label" for="motivo">Motivo</label>
          <select class="form-select" id="motivo" name="motivo" required>
            <option value="">Seleccione un motivo</option>
            <option>Consulta de programas</option><option>Pagos</option>
            <option>Información general</option><option>Reclamos</option><option>Otros</option>
          </select>
        </div>
        <button class="btn btn-primary w-100" type="submit">Agendar Cita</button>
      </form>
    </div>
  </section>


  <div class="container my-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3">Mis próximas citas</h5>
        <ul class="list-group">
          <?php
            require_once("../accesoDatos/conexion.php");
            try{
              $cn=abrirConexion();
              $idUsuario=1; // luego usar $_SESSION['id_usuario']
              $q=$cn->prepare("SELECT fecha_cita,motivo,estado FROM CITAS WHERE id_usuario=? AND fecha_cita>=NOW() ORDER BY fecha_cita ASC LIMIT 20");
              $q->bind_param("i",$idUsuario); $q->execute(); $res=$q->get_result();
              if($res->num_rows===0) echo '<li class="list-group-item">No tenés citas próximas.</li>';
              while($r=$res->fetch_assoc()){
                echo '<li class="list-group-item"><strong>'.htmlspecialchars($r['motivo']).'</strong> — '.$r['fecha_cita'].' <span class="badge bg-secondary ms-2">'.$r['estado'].'</span></li>';
              }
            }catch(Exception $e){ echo '<li class="list-group-item text-danger">No se pudieron cargar las citas.</li>'; }
            finally{ if(isset($cn)) cerrarConexion($cn); }
          ?>
        </ul>
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
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("#fecha_cita",{ enableTime:true, dateFormat:"Y-m-d H:i", time_24hr:true, minDate:"today" });
  </script>
</body>
</html>
