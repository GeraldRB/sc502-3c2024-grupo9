<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$resultado = $conexion->query(
    "SELECT id_programa, titulo, descripcion, nivel, fecha_inicio, fecha_fin, estado
     FROM programas_educativos
     ORDER BY id_programa DESC"
);

if (!$resultado) {
    echo "Error: " . $conexion->error;
}

cerrarConexion($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Programas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

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
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 1;
        }

        main>* {
            position: relative;
            z-index: 2;
        }

        .card {
            padding: 2rem;
            margin-top: 3px;
            width: 100%;
            max-width: 1500px;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 150px;
            display: block;
            margin: 0 auto 1rem auto;
        }

        .btn-primary {
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

        footer p {
            margin: 3px 0;
        }

        #tablaProgramas thead th {
            background-color: #20b2aa !important;
            color: #fff !important;
            border-color: #198c85 !important;
        }

        #tablaProgramas tbody tr:nth-child(odd) {
            background: #f0fbfa;
        }

        #tablaProgramas tbody tr:hover {
            background: #e7f7f5;
        }

        .dataTables_wrapper .dataTables_paginate .page-item.active .page-link {
            background-color: #20b2aa;
            border-color: #ffffffff;
        }

        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #20b2aa;
            box-shadow: 0 0 0 .25rem rgba(32, 178, 170, .25);
        }
    </style>
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light px-4">
        <a class="navbar-brand" href="../index.php">
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
                <li class="nav-item"><a class="nav-link active" href="listaProgramas.php">Lista de Programas</a></li>
            </ul>
        </div>
    </nav>

    <main>
        <div class="card p-4 shadow-lg mb-5">
            <form id="formPrograma" method="POST">
                <div>
                    <img src="../../public/logo.jpg" alt="REDCUDI Logo" class="logo">
                    <h2 class="fw-bold text-center mb-3">Lista de Programas</h2>
                    <div class="table-responsive">
                        <table id="tablaProgramas" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                    <th>Nivel</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultado && $resultado->num_rows): ?>
                                    <?php while ($u = $resultado->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($u["titulo"]) ?></td>
                                            <td><?= htmlspecialchars($u["descripcion"]) ?></td>
                                            <td><?= htmlspecialchars($u["nivel"]) ?></td>
                                            <td><?= htmlspecialchars($u["fecha_inicio"]) ?></td>
                                            <td><?= htmlspecialchars($u["fecha_fin"]) ?></td>
                                            <td><?= $u["estado"] ? 'Activo' : 'Inactivo' ?></td>
                                            <td>
    <div class="d-flex gap-2 justify-content-center">
        <a href="editarListaProgramas.php?id=<?= $u['id_programa'] ?>" class="btn btn-primary btn-sm">Editar</a>
        <a href="eliminarListaProgramas.php?id=<?= $u['id_programa'] ?>" class="btn btn-danger btn-sm"
           onclick="return confirm('¿Seguro que deseas eliminar este programa?')">Eliminar</a>
    </div>
</td>

                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Sin programas</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tablaProgramas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 5
            });
        });
    </script>

    <footer>
        <p><strong>Modalidad:</strong> C.I.D.A.I.</p>
        <p><strong>Provincia:</strong> San José &nbsp;&nbsp; <strong>Cantón:</strong> San José</p>
        <p><strong>Distrito:</strong> Hospital</p>
        <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Pley, contiguo a Iglesia Casa de Bendición</p>
        <p><strong>Teléfono:</strong> 2221-7722</p>
        <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
    </footer>
</body>

</html>