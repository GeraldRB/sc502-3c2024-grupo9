<?php
require_once '../models/user.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../view/login.php');
        exit;
    }

    $action = $_POST['action'] ?? '';
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($action === 'login') {
        if ($correo !== '' && $password !== '' && User::login($correo, $password)) {
            header('Location: ../view/index.php');
            exit;
        } else {
            header('Location: ../view/login.php?error=Usuario+o+clave+inválidos');
            exit;
        }
    } else {
        header('Location: ../view/login.php');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../view/login.php?error=Error+interno');
    exit;
}