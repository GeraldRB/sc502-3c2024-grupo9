<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Guardería Ministerio de la Misericordia</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100dvh;
      font-family: 'Poppins', sans-serif;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }

    .navbar {
      background-color: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .navbar-brand img {
      height: 50px;
    }

    main {
      flex: 1;
      background: url("../public/guarderia.png") center center/cover no-repeat;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    main::before {
      content: "";
      position: absolute;
      top: 0; 
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.6);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      text-align: center;
      max-width: 800px;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.85);
      border-radius: 12px;
    }

    .hero-content h1 {
      font-size: 2.6rem;
      font-weight: bold;
      color: #000;
    }

    .hero-content p {
      font-size: 1.2rem;
      color: #333;
      margin-bottom: 20px;
    }

    .hero-content .btn {
      font-size: 1.1rem;
      padding: 10px 25px;
      background-color: #20b2aa;
      border: none;
      color: white;
    }

    .hero-content .btn:hover {
      background-color: #198c85;
    }

    footer {
      background-color: #20b2aa;
      color: white;
      padding: 12px 20px;
      text-align: center;
      font-size: 0.9rem;
    }

    footer p {
      margin: 3px 0;
    }

    @media (max-width: 768px) {
      .hero-content h1 {
        font-size: 1.8rem;
      }

      .hero-content p {
        font-size: 1rem;
      }
    }
  </style>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-light px-4">
    <a class="navbar-brand" href="#">
      <img src="../public/logo.jpg" alt="REDCUDI Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="recomendaciones.php">Recomendaciones</a></li>
        <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
        <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
        <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
        <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
        <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
        <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
      </ul>
    </div>
  </nav>

  <main>
    <div class="hero-content">
      <h1>Bienvenido al Centro de Atención Integral</h1>
      <p>Ministerio de la Misericordia - Parte de la Red Nacional de Cuido y Desarrollo Infantil (REDCUDI)</p>
      <a href="matricula.php" class="btn">Matricúlate ahora</a>
    </div>
  </main>

  <footer>
    <p><strong>Modalidad:</strong> C.I.D.A.I.</p>
    <p><strong>Provincia:</strong> San José &nbsp;&nbsp; <strong>Cantón:</strong> San José</p>
    <p><strong>Distrito:</strong> Hospital</p>
    <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Pley, contiguo a Iglesia Casa de Bendición</p>
    <p><strong>Teléfono:</strong> 2221-7722</p>
    <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>