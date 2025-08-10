<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../styles/estilos.css">
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="text-center mb-4">
      <h1 class="fw-bold">Contacto</h1>
      <p class="lead">Envíanos tus consultas o comentarios y te respondemos pronto.</p>

      <?php if (isset($_GET["ok"])): ?>
        <div class="alert alert-success">Mensaje enviado correctamente.</div>
      <?php elseif (isset($_GET["err"])): ?>
        <div class="alert alert-danger">No se pudo enviar. Intenta de nuevo.</div>
      <?php endif; ?>
    </div>

    <div class="card p-4 shadow-lg">
      <form method="POST" action="../controller/contacto.php">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre completo</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
          <label for="correo" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="correo" name="correo" required>
        </div>

        <div class="mb-3">
          <label for="mensaje" class="form-label">Mensaje</label>
          <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Enviar mensaje</button>
      </form>
    </div>

    <div class="mt-5">
      <h2 class="fw-bold text-center mb-3">Mensajes recibidos</h2>
      <ul class="list-group">
        <?php
          require_once("../accesoDatos/conexion.php");
          try {
            $cn = abrirConexion();
            $rs = $cn->query("SELECT nombre, correo, mensaje, fecha_envio FROM CONTACTO ORDER BY id_contacto DESC LIMIT 20");
            while ($row = $rs->fetch_assoc()):
        ?>
          <li class="list-group-item">
            <strong><?php echo htmlspecialchars($row["nombre"]); ?></strong>
            (<em><?php echo htmlspecialchars($row["correo"]); ?></em>)<br>
            <?php echo nl2br(htmlspecialchars($row["mensaje"])); ?>
            <div class="text-muted small">Enviado: <?php echo $row["fecha_envio"]; ?></div>
          </li>
        <?php
            endwhile;
          } catch (Exception $e) {
            echo '<li class="list-group-item text-danger">No se pudieron cargar los mensajes.</li>';
          } finally {
            if (isset($cn)) cerrarConexion($cn);
          }
        ?>
      </ul>
    </div>
  </div>
</body>
</html>