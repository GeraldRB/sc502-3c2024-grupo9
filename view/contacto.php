<?php
session_start();

if (!isset($_SESSION['usuarioID'], $_SESSION['id_rol'])) {
    header("Location: ./login.php?error=" . urlencode("Inicie sesión para continuar."));
    exit;
}

$rol = $_SESSION['id_rol'];
$nombre = $_SESSION['nombre'] ?? "";
$correo = $_SESSION['correo'] ?? "";
$ok = isset($_GET['ok']);
$err = isset($_GET['err']);

require_once("../accesoDatos/conexion.php");
$mensajes = [];
if ($rol == 1) {
    $cn = abrirConexion();
    $consulta = $cn->query("SELECT * FROM contacto ORDER BY fecha_envio DESC");
    while ($row = $consulta->fetch_assoc()) {
        $mensajes[] = $row;
    }
    cerrarConexion($cn);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contacto | Guardería</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f9ff;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand img {
            height: 50px;
        }

        .navbar-nav .nav-link {
            color: #333;
            margin: 0 10px;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #20b2aa;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            padding: 2rem;
            width: 100%;
            max-width: 600px;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .btn-success {
            background-color: #20b2aa;
            border-color: #20b2aa;
        }

        .btn-success:hover {
            background-color: #198c85;
            border-color: #198c85;
        }

        .tabla-mensajes {
            margin: 30px auto;
            width: 95%;
            max-width: 900px;
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .tabla-mensajes h3 {
            text-align: center;
            color: #20b2aa;
            margin-bottom: 20px;
            font-weight: bold;
        }

        footer {
            background-color: #20b2aa;
            color: white;
            text-align: center;
            font-size: 0.9rem;
            padding: 15px 20px;
        }

        footer p {
            margin: 3px 0;
        }

        table {
            border-radius: 8px;
            overflow: hidden;
        }

        th {
            background-color: #e6f7f5;
        }

        .logo {
            width: 150px;
            display: block;
            margin: 0 auto 1rem auto;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <a class="navbar-brand" href="index.php">
            <img src="../public/logo.jpg" alt="REDCUDI Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($rol == 1 || $rol == 2): ?>
                    <li class="nav-item"><a class="nav-link" href="recomendaciones.php">Recomendaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="matricula.php">Matrícula</a></li>
                    <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="citas.php">Citas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
                <?php endif; ?>

                <?php if ($rol == 1): ?>
                    <li class="nav-item"><a class="nav-link" href="programas.php">Programas Educativos</a></li>
                    <li class="nav-item"><a class="nav-link" href="tablas/listaProgramas.php">Lista de Programas</a></li>
                    <li class="nav-item"><a class="nav-link" href="usuarios/listaUsuarios.php">Lista de Usuarios</a></li>
                <?php endif; ?>

                <?php if ($rol == 3): ?>
                    <li class="nav-item"><a class="nav-link" href="faqs.php">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php if ($rol == 2 || $rol == 3): ?>
        <main>
            <div class="card shadow">
                <img src="../public/logo.jpg" alt="REDCUDI Logo" class="logo">
                <h3 class="mb-4 text-center">Formulario de Contacto</h3>
                <?php if ($ok): ?>
                    <div class="alert alert-success">Mensaje enviado correctamente.</div><?php endif; ?>
                <?php if ($err): ?>
                    <div class="alert alert-danger">Error al enviar el mensaje. Intente de nuevo.</div><?php endif; ?>
                <form method="POST" action="../controller/contacto.php">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                            value="<?= htmlspecialchars($nombre) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" name="correo" id="correo" class="form-control"
                            value="<?= htmlspecialchars($correo) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje</label>
                        <textarea name="mensaje" id="mensaje" rows="4" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Enviar</button>
                </form>
            </div>
        </main>
    <?php endif; ?>

    <?php if ($rol == 1): ?>
        <div class="tabla-mensajes">
            <h3>Mensajes Recibidos</h3>
            <?php if (empty($mensajes)): ?>
                <p class="text-muted text-center">Aún no hay mensajes.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Mensaje</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($mensajes as $m): ?>
                                <tr>
                                    <td><?= htmlspecialchars($m["nombre"]) ?></td>
                                    <td><?= htmlspecialchars($m["correo"]) ?></td>
                                    <td><?= htmlspecialchars($m["mensaje"]) ?></td>
                                    <td><?= htmlspecialchars($m["fecha_envio"]) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <footer class="mt-auto">
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