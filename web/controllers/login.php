<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/UserModel.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userModel = new UserModel();
    $usuarioInput = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    // Guardamos el resultado en $datosUsuario
    $datosUsuario = $userModel->validarLogin($usuarioInput, $password);

    if ($datosUsuario) {
        // AQUÍ ESTABA EL FALLO: Usamos $datosUsuario en lugar de $usuario
        $_SESSION['user_id'] = $datosUsuario['idUser'];
        $_SESSION['nombre'] = $datosUsuario['nombre'];
        $_SESSION['rol'] = $datosUsuario['rol'];

        // Mensaje temporal de bienvenida en la sesión
        $_SESSION['bienvenida'] = "¡Bienvenido de nuevo, " . $datosUsuario['nombre'] . "!";

        header('Location: index.php?seccion=home'); 
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}

require_once __DIR__ . '/../views/login.php';
?>