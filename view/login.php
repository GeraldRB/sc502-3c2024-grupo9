<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión | REDCUDI</title>
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
      max-width: 420px;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .logo {
      width: 150px;
      display: block;
      margin: 0 auto 1rem auto;
    }
    .btn-primary {
      background-color: #20b2aa;
      border-color: #20b2aa;
    }
    .btn-primary:hover {
      background-color: #198c85;
      border-color: #198c85;
    }
  </style>
</head>
<body>

  <div class="card">
    <img src="../public/logo.jpg" alt="REDCUDI Logo" class="logo">

    <h3 class="text-center mb-4">Iniciar Sesión</h3>

    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
      <div class="alert alert-danger text-center">Correo o contraseña incorrectos</div>
    <?php endif; ?>

    <form method="POST" action="../controller/login.php">
      <div class="mb-3">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="correo" name="correo" placeholder="usuario@ejemplo.com" required>
      </div>

      <div class="mb-3">
        <label for="contraseña" class="form-label">Contraseña</label>
        <input type="password" class="form-control" id="contraseña" name="contraseña" placeholder="••••••••" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <span>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></span>
    </div>
  </div>

</body>
</html>