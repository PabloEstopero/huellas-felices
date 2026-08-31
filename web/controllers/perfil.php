<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Si el usuario no ha iniciado sesión, lo redirigimos al login
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?seccion=login');
    exit;
}

require_once __DIR__ . '/../models/UserModel.php';
$userModel = new UserModel();

$error = '';
$exito = '';
$idUser = $_SESSION['user_id'];

# Obtenemos los datos actuales del usuario para mostrarlos en el formulario
$usuarioData = $userModel->obtenerPorId($idUser);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    # Recogemos los datos enviados
    $datosActualizados = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellidos' => trim($_POST['apellidos'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'direccion' => trim($_POST['direccion'] ?? ''),
        'sexo' => $_POST['sexo'] ?? '',
        'password' => $_POST['password'] ?? '' 
    ];

    # Validaciones básicas de campos obligatorios
    if (in_array('', [
        $datosActualizados['nombre'], $datosActualizados['apellidos'], 
        $datosActualizados['email'], $datosActualizados['telefono'], 
        $datosActualizados['fecha_nacimiento'], $datosActualizados['sexo']
    ], true)) {
        $error = 'Por favor, rellena todos los campos obligatorios.';
    } elseif (!filter_var($datosActualizados['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'El formato del correo electrónico no es válido.';
    } else {
        # Actualizamos en la base de datos
        $resultado = $userModel->actualizarPerfil($idUser, $datosActualizados);

        if ($resultado) {
            $exito = 'Perfil actualizado correctamente.';
            # Actualizamos también la variable de sesión del nombre por si cambió
            $_SESSION['nombre'] = $datosActualizados['nombre'];
            # Refrescamos los datos en pantalla
            $usuarioData = $userModel->obtenerPorId($idUser);
        } else {
            $error = 'Hubo un error al actualizar el perfil. Es posible que el email ya esté en uso.';
        }
    }
}

# Cargamos la vista del perfil
require_once __DIR__ . '/../views/perfil.php';
?>