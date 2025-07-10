<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Guardería - Inicio</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f0f2f5;
    }
    .container {
      margin-top: 60px;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card i {
      font-size: 2rem;
      margin-bottom: 10px;
      color: #0d6efd;
    }
  </style>
</head>
<body>

  <div class="container text-center">
    <h1 class="mb-4">Bienvenido a la Guardería</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">

      <div class="col">
        <div class="card p-4">
          <i class="bi bi-heart-pulse-fill"></i>
          <h5 class="card-title">Servicios</h5>
          <a href="consejosRecomendacions.html" class="btn btn-outline-primary mt-2">Ir</a>
        </div>
      </div>

      <div class="col">
        <div class="card p-4">
          <i class="bi bi-person-plus-fill"></i>
          <h5 class="card-title">Matrícula</h5>
          <a href="matricula.html" class="btn btn-outline-primary mt-2">Ir</a>
        </div>
      </div>

      <div class="col">
        <div class="card p-4">
          <i class="bi bi-journal-text"></i>
          <h5 class="card-title">Programas Educativos</h5>
          <a href="primero.html" class="btn btn-outline-primary mt-2">Ir</a>
        </div>
      </div>

      <div class="col">
        <div class="card p-4">
          <i class="bi bi-calendar-event-fill"></i>
          <h5 class="card-title">Citas</h5>
          <a href="citas.html" class="btn btn-outline-primary mt-2">Ir</a>
        </div>
      </div>

      <div class="col">
        <div class="card p-4">
          <i class="bi bi-book-fill"></i>
          <h5 class="card-title">Programas</h5>
          <a href="programa.html" class="btn btn-outline-primary mt-2">Ir</a>
        </div>
      </div>

      <div class="col">
        <div class="card p-4">
          <i class="bi bi-envelope-fill"></i>
          <h5 class="card-title">Contacto</h5>
          <a href="contacto.html" class="btn btn-outline-primary mt-2">Ir</a>
        </div>
      </div>

    </div>
  </div>

</body>
</html>