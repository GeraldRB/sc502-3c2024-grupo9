<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Usuario | REDCUDI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f9ff;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      padding: 2rem;
      width: 100%;
      max-width: 480px;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
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
  </style>
</head>
<body>

  <div class="card">
    <img src="../public/logo.jpg" alt="REDCUDI Logo" class="logo">

    <h3 class="text-center mb-3">Registro de Usuario</h3>

    <?php if (isset($_GET['existe'])): ?>
      <div class="alert alert-warning text-center">El correo ya está registrado.</div>
    <?php elseif (isset($_GET['ok'])): ?>
      <div class="alert alert-success text-center">¡Usuario registrado con éxito!</div>
    <?php elseif (isset($_GET['error'])): ?>
      <div class="alert alert-danger text-center">Hubo un error al registrar el usuario.</div>
    <?php endif; ?>

    <form method="POST" action="../controller/registro.php">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre completo</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" required>
      </div>
      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-success">Registrarse</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <span>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></span>
    </div>
  </div>

</body>
</html>