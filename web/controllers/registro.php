<?php
# CONTROLADOR DE REGISTRO
require_once __DIR__ . '/../models/UserModel.php';

$error = '';
# Inicializamos el array de datos vacío para la primera carga
$datos = [
    'nombre' => '', 'apellidos' => '', 'email' => '', 
    'telefono' => '', 'fecha_nacimiento' => '', 'direccion' => '', 
    'sexo' => '', 'usuario' => '', 'password' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    # Recogemos los datos enviados
    $datos = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellidos' => trim($_POST['apellidos'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'direccion' => trim($_POST['direccion'] ?? ''),
        'sexo' => $_POST['sexo'] ?? '',
        'usuario' => trim($_POST['usuario'] ?? ''),
        'password' => $_POST['password'] ?? ''
    ];

    # Validaciones
    if (in_array('', $datos, true)) {
        $error = 'Por favor, rellena todos los campos obligatorios.';
    } elseif (!preg_match('/^[A-ZÁÉÍÓÚÑ]/u', $datos['nombre'])) {
        $error = 'El nombre debe empezar por una letra mayúscula.';
    } elseif (!preg_match('/^[A-ZÁÉÍÓÚÑ]/u', $datos['apellidos'])) {
        $error = 'Los apellidos deben empezar por una letra mayúscula.';
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'El formato del correo electrónico no es válido.';
    } elseif (!preg_match('/^[0-9\s\-\+]{9,15}$/', $datos['telefono'])) {
        $error = 'El teléfono debe contener entre 9 y 15 dígitos válidos.';
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/', $datos['password'])) {
        $error = 'La contraseña debe tener al menos 6 caracteres, incluyendo una letra y un número.';
    } else {
        $userModel = new UserModel();
        if ($userModel->registrar($datos)) {
            header('Location: index.php?seccion=login&registrado=success');
            exit;
        } else {
            $error = 'Hubo un error al registrar. El usuario o email ya existen.';
        }
    }
}

require_once __DIR__ . '/../views/registro.php';
?>