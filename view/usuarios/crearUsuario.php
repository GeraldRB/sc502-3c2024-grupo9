<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}

$rol = $_SESSION['id_rol'];

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$nombre = $correo = $contraseña = "";
$estado = 1;
$mensajeError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);
    $rolSeleccionado = (int) $_POST['id_rol'];
    $estado = isset($_POST['estado']) ? 1 : 0;
    $fecha = date('Y-m-d H:i:s');

    if ($nombre === "" || $correo === "" || $contraseña === "" || $rolSeleccionado <= 0) {
        $mensajeError = "Todos los campos son obligatorios.";
    } else {
        $sql = "INSERT INTO usuarios (nombre, correo, contraseña, id_rol, estado, fecha_registro)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssiss", $nombre, $correo, $contraseña, $rolSeleccionado, $estado, $fecha);

        if ($stmt->execute()) {
            cerrarConexion($conexion);
            echo '<script>
                    alert("Usuario registrado correctamente.");
                    window.location.href = "listaUsuarios.php";
                  </script>';
            exit;
        } else {
            $mensajeError = "Error al registrar: " . $stmt->error;
        }
    }
}

$roles = $conexion->query("SELECT id_rol, nombre_rol FROM roles");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f9ff;
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
            background: url("../../public/backgraund.jpg") center no-repeat;
            background-size: cover;
            min-height: 80vh;
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
            background-color: rgba(255, 255, 255, 0.85);
            z-index: 1;
        }

        main>* {
            position: relative;
            z-index: 2;
        }

        .card {
            padding: 2rem;
            margin-top: 2rem;
            width: 100%;
            max-width: 800px;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .btn-success {
            background-color: #17847e;
            border-color: #17847e;
        }

        footer {
            background-color: #20b2aa;
            color: white;
            padding: 12px 20px;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <a class="navbar-brand" href="../index.php">
            <img src="../../public/logo.jpg" alt="REDCUDI Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">

                <?php if ($rol == 1 || $rol == 2): ?>
                    <li class="nav-item"><a class="nav-link" href="../recomendaciones.php">Recomendaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="../matricula.php">Matrícula</a></li>
                    <li class="nav-item"><a class="nav-link" href="../faqs.php">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="../citas.php">Citas</a></li>
                    <li class="nav-item"><a class="nav-link" href="../contacto.php">Contacto</a></li>
                <?php endif; ?>

                <?php if ($rol == 1): ?>
                    <li class="nav-item"><a class="nav-link" href="../programas.php">Programas Educativos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../tablas/listaProgramas.php">Lista de Programas</a></li>
                    <li class="nav-item"><a class="nav-link active" href="listaUsuarios.php">Lista de Usuarios</a></li>
                <?php endif; ?>

                <?php if ($rol == 3): ?>
                    <li class="nav-item"><a class="nav-link" href="../faqs.php">FAQs</a></li>
                    <li class="nav-item"><a class="nav-link" href="../contacto.php">Contacto</a></li>
                <?php endif; ?>

            </ul>
        </div>
    </nav>

    <main>
        <div class="card">
<h3 class="text-center mb-4" style="color: #20b2aa; font-weight: 600;">
  <i class="fas fa-user-plus me-2"></i>Registrar Usuario
</h3>


            <?php if ($mensajeError): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($mensajeError) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($correo) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="contraseña" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="id_rol" class="form-select" required>
                        <option value="">Seleccione un rol</option>
                        <?php while ($r = $roles->fetch_assoc()): ?>
                            <option value="<?= $r['id_rol'] ?>" <?= ($rolSeleccionado ?? '') == $r['id_rol'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($r['nombre_rol']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="estado" id="estado" <?= $estado ? 'checked' : '' ?>>
                    <label class="form-check-label" for="estado">Activo</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-user-plus me-1"></i> Registrar
                    </button>
                    <a href="listaUsuarios.php" class="btn btn-secondary">
                        <i class="fa-solid fa-ban me-1"></i> Cancelar
                    </a>
                </div>
            </form>
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