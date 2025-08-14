<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once("../../accesoDatos/conexion.php");
$conexion = abrirConexion();

$sql = "SELECT u.id_usuario, u.nombre, u.correo, r.nombre_rol, u.estado, u.fecha_registro
        FROM usuarios u
        JOIN roles r ON u.id_rol = r.id_rol
        ORDER BY u.id_usuario DESC";

$resultado = $conexion->query($sql);
cerrarConexion($conexion);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
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
            background-color: rgba(255, 255, 255, 0.85);
            z-index: 1;
        }

        main>* {
            position: relative;
            z-index: 2;
        }

        .card {
            padding: 2rem;
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

        #tablaUsuarios thead th {
            background-color: #20b2aa !important;
            color: #fff !important;
            border-color: #198c85 !important;
        }

        #tablaUsuarios tbody tr:nth-child(odd) {
            background: #f0fbfa;
        }

        #tablaUsuarios tbody tr:hover {
            background: #e7f7f5;
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
                <li class="nav-item"><a class="nav-link active" href="listaUsuarios.php">Lista de Usuarios</a></li>
            </ul>
        </div>
    </nav>


    <main>
        <div class="card p-4 shadow-lg mb-5">
            <img src="../../public/logo.jpg" alt="REDCUDI Logo" class="logo">
            <h2 class="fw-bold text-center mb-3">Lista de Usuarios</h2>

            <div class="mb-3 text-end">
                <a href="crearUsuario.php" class="btn btn-success">+ Agregar Usuario</a>
            </div>

            <div class="table-responsive">
                <table id="tablaUsuarios" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultado && $resultado->num_rows): ?>
                            <?php while ($u = $resultado->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u["nombre"]) ?></td>
                                    <td><?= htmlspecialchars($u["correo"]) ?></td>
                                    <td><?= htmlspecialchars($u["nombre_rol"]) ?></td>
                                    <td><?= $u["estado"] ? 'Activo' : 'Inactivo' ?></td>
                                    <td><?= date("d/m/Y", strtotime($u["fecha_registro"])) ?></td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="editarUsuario.php?id=<?= $u['id_usuario'] ?>"
                                                class="btn btn-primary btn-sm">Editar</a>
                                            <a href="eliminarUsuario.php?id=<?= $u['id_usuario'] ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay usuarios registrados</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer style="background-color: #20b2aa; color: white; padding: 20px 0; text-align: center; font-size: 0.9rem;">
        <p><strong>Modalidad:</strong> C.I.D.A.I.</p>
        <p><strong>Provincia:</strong> San José &nbsp;&nbsp; <strong>Cantón:</strong> San José</p>
        <p><strong>Distrito:</strong> Hospital</p>
        <p><strong>Dirección:</strong> Barrio Cuba Los Pinos, detrás del Pley, contiguo a Iglesia Casa de Bendición</p>
        <p><strong>Teléfono:</strong> 2221-7722</p>
        <p><strong>Correo:</strong> ministeriodelamisericordia2017@gmail.com</p>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tablaUsuarios').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                responsive: true,
                pageLength: 5
            });
        });
    </script>
</body>

</html>