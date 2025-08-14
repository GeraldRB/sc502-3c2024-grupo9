<?php
require_once __DIR__ . '/../accesoDatos/conexion.php';

class User {
    public static function login($correo, $password) {
        $cn = abrirConexion();
        if (!$cn || $cn->connect_error) {
            return false;
        }

        $sql = "SELECT id_usuario, nombre, correo, contraseña, id_rol, estado
                FROM usuarios
                WHERE correo = ?";
        $stmt = $cn->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $correo);
        if (!$stmt->execute()) {
            return false;
        }

        $rs = $stmt->get_result();
        if ($rs->num_rows === 1) {
            $u = $rs->fetch_assoc();

            if (trim($password) === trim($u['contraseña']) && (int)$u['estado'] === 1) {
                if (session_status() !== PHP_SESSION_ACTIVE) session_start();
                session_regenerate_id(true);

                $_SESSION['usuarioID'] = (int)$u['id_usuario'];
                $_SESSION['nombre']    = $u['nombre'];
                $_SESSION['correo']    = $u['correo'];
                $_SESSION['id_rol']    = (int)$u['id_rol'];

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}