<?php
session_start();

if (isset($_SESSION["usuarioID"]) && isset($_SESSION["id_rol"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión | REDCUDI</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #eaf6fc;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 380px;
      text-align: center;
    }

    .login-container img {
      height: 70px;
      margin-bottom: 10px;
    }

    .form-title {
      font-size: 20px;
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
    }

    .form-label {
      font-weight: 500;
      font-size: 14px;
    }

    .form-control {
      font-size: 14px;
    }

    .btn-login {
      background-color: #1abc9c;
      color: white;
      font-weight: 500;
      border: none;
    }

    .btn-login:hover {
      background-color: #159d83;
    }

    .small-text {
      font-size: 13px;
      margin-top: 15px;
    }

    .small-text a {
      color: #007bff;
      text-decoration: none;
    }

    .small-text a:hover {
      text-decoration: underline;
    }

    .alert {
      font-size: 14px;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <img src="../public/logo.jpg" alt="REDCUDI Logo">
    <div class="form-title">Iniciar Sesión</div>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <form action="../controller/authController.php" method="POST">
      <input type="hidden" name="action" value="login">

      <div class="mb-3 text-start">
        <label for="correo" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" name="correo" id="correo" placeholder="usuario@ejemplo.com" required>
      </div>

      <div class="mb-3 text-start">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" class="form-control" name="password" id="password" required>
      </div>

      <button type="submit" class="btn btn-login w-100">Ingresar</button>
    </form>

    <p class="small-text">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
  </div>

</body>
</html>