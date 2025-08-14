<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0)
    exit("ID invalido");

$errorr = "";

// guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tituloo = trim($_POST['titulo'] ?? '');
    $descripcionn = trim($_POST['descripcion'] ?? '');
    $nivell = trim($_POST['nivel'] ?? '');
    $fechaI = $_POST['fecha_inicio'] ?? null;
    $fechaF = $_POST['fecha_fin'] ?? null;
    $estadoo = isset($_POST['estado']) ? 1 : 0;

    if ($fechaI && $fechaF && $fechaI > $fechaF) {
        $errorr = "La fecha de inicio no puede ser mayor que la fecha fin.";
    }

    if (!$errorr) {
        $sql = "UPDATE programas_educativos
                   SET titulo=?, descripcion=?, nivel=?, fecha_inicio=?, fecha_fin=?, estado=?
                 WHERE id_programa=?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("sssssii", $tituloo, $descripcionn, $nivell, $fechaI, $fechaF, $estadoo, $id);

        if ($stmt->execute()) {
            echo '<script>
                    alert("El programa se actualizó correctamente.");
                    window.location.href = "listaProgramas.php";
                  </script>';
            exit;
        } else {
            $errorr = "Error al actualizar: " . $stmt->error;
        }
    }
}

// cargar datos
$stmt = $conexion->prepare("SELECT id_programa, titulo, descripcion, nivel, fecha_inicio, fecha_fin, estado
                             FROM programas_educativos WHERE id_programa=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$programa = $res->fetch_assoc();
if (!$programa)
    exit("Programa no encontrado.");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Programa Educativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
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
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }

        main > * {
            position: relative;
            z-index: 2;
        }

        .card {
            padding: 2rem;
            margin-top: 2rem;
            width: 100%;
            max-width: 900px;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .btn-success {
            background-color: #198c85;
            border-color: #198c85;
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
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <a class="navbar-brand" href="#">
            <img src="../../public/logo.jpg" alt="REDCUDI Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="../recomendaciones.php">Recomendaciones</a></li>
                <li class="nav-item"><a class="nav-link" href="../matricula.php">Matrícula</a></li>
                <li class="nav-item"><a class="nav-link" href="../faqs.php">FAQs</a></li>
                <li class="nav-item"><a class="nav-link" href="../citas.php">Citas</a></li>
                <li class="nav-item"><a class="nav-link" href="../programas.php">Programas Educativos</a></li>
                <li class="nav-item"><a class="nav-link" href="../contacto.php">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="card">
            <div class="container mt-3">
                <h2 class="text-center mb-4">Editar Programa Educativo</h2>

                <?php if (!empty($errorr)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errorr) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <input type="hidden" name="id_programa" value="<?= (int) $programa['id_programa'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($programa['titulo']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" required><?= htmlspecialchars($programa['descripcion']) ?></textarea>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Nivel</label>
                            <select name="nivel" class="form-select" required>
                                <option value="">Seleccione nivel</option>
                                <option value="Preescolar" <?= $programa['nivel'] == 'Preescolar' ? 'selected' : '' ?>>Preescolar</option>
                                <option value="Primaria" <?= $programa['nivel'] == 'Primaria' ? 'selected' : '' ?>>Primaria</option>
                                <option value="Secundaria" <?= $programa['nivel'] == 'Secundaria' ? 'selected' : '' ?>>Secundaria</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" class="form-control" value="<?= htmlspecialchars($programa['fecha_inicio']) ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" name="fecha_fin" class="form-control" value="<?= htmlspecialchars($programa['fecha_fin']) ?>">
                        </div>
                    </div>

                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" type="checkbox" id="estado" name="estado" <?= $programa['estado'] ? 'checked' : '' ?>>
                        <label class="form-check-label" for="estado">Activo</label>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-success" type="submit">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Guardar
                        </button>
                        <a class="btn btn-secondary" href="listaProgramas.php">
                            <i class="fa-solid fa-ban me-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
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