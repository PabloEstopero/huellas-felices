<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Seguridad: Solo admin
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php?seccion=home');
    exit;
}

require_once __DIR__ . '/../models/UserModel.php';
$userModel = new UserModel();

$error = '';
$exito = '';
$accion = $_GET['accion'] ?? 'listar';
$idUsuario = intval($_GET['id'] ?? 0);

# 1. PROCESAR CREACIÓN DE USUARIO (CON LAS MISMAS VALIDACIONES DE REGISTRO)
if ($accion === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellidos' => trim($_POST['apellidos'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'direccion' => trim($_POST['direccion'] ?? ''),
        'sexo' => $_POST['sexo'] ?? '',
        'usuario' => trim($_POST['usuario'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'rol' => $_POST['rol'] ?? 'user'
    ];

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
        # Usamos un método adaptado en el modelo que acepte el rol personalizado
        if ($userModel->crearUsuarioAdmin($datos)) {
            header('Location: index.php?seccion=usuarios-administracion&exito=creado');
            exit;
        } else {
            $error = 'Hubo un error al crear el usuario. El usuario o email ya existen.';
        }
    }
}

# 2. PROCESAR EDICIÓN DE USUARIO (POST)
if ($accion === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => trim($_POST['nombre'] ?? ''),
        'apellidos' => trim($_POST['apellidos'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
        'direccion' => trim($_POST['direccion'] ?? ''),
        'sexo' => $_POST['sexo'] ?? '',
        'usuario' => trim($_POST['usuario'] ?? ''),
        'password' => $_POST['password'] ?? '', # Si viene vacía, no se cambia
        'rol' => $_POST['rol'] ?? 'user'
    ];

    # Validaciones generales de campos obligatorios, formato, etc.
    if (empty($datos['nombre']) || empty($datos['apellidos']) || empty($datos['email']) || empty($datos['usuario'])) {
        $error = 'Por favor, rellena los campos obligatorios principales.';
    } elseif (!preg_match('/^[A-ZÁÉÍÓÚÑ]/u', $datos['nombre'])) {
        $error = 'El nombre debe empezar por una letra mayúscula.';
    } elseif (!preg_match('/^[A-ZÁÉÍÓÚÑ]/u', $datos['apellidos'])) {
        $error = 'Los apellidos deben empezar por una letra mayúscula.';
    } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
        $error = 'El formato del correo electrónico no es válido.';
    } elseif (!empty($datos['password']) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{6,}$/', $datos['password'])) {
        # Si han escrito algo en la contraseña, exigimos el formato seguro
        $error = 'La contraseña debe tener al menos 6 caracteres, incluyendo una letra y un número.';
    } else {
        # Si todo es correcto (y si la contraseña cumple el patrón o está vacía), actualizamos
        if ($userModel->actualizarUsuarioAdmin($idUsuario, $datos)) {
            header('Location: index.php?seccion=usuarios-administracion&exito=editado');
            exit;
        } else {
            $error = 'Error al actualizar los datos del usuario.';
        }
    }
}

# 3. PROCESAR ELIMINACIÓN
if ($accion === 'eliminar') {
    if ($idUsuario === $_SESSION['user_id']) {
        $error = 'No puedes eliminar tu propia cuenta de administrador.';
    } else {
        if ($userModel->eliminarUsuario($idUsuario)) {
            header('Location: index.php?seccion=usuarios-administracion&exito=eliminado');
            exit;
        } else {
            $error = 'No se pudo eliminar el usuario.';
        }
    }
}

# Capturar mensajes de éxito por URL (patrón PRG)
if (isset($_GET['exito'])) {
    if ($_GET['exito'] === 'creado') $exito = 'Usuario creado correctamente.';
    if ($_GET['exito'] === 'editado') $exito = 'Usuario modificado correctamente.';
    if ($_GET['exito'] === 'eliminado') $exito = 'Usuario eliminado correctamente.';
}

# Cargar vistas según la acción solicitada por URL
if ($accion === 'crear') {
    # Si $datos no está definido (porque es la primera vez que entramos), lo inicializamos vacío
    if (!isset($datos)) {
        $datos = [
            'nombre' => '', 'apellidos' => '', 'email' => '', 
            'telefono' => '', 'fecha_nacimiento' => '', 'direccion' => '', 
            'sexo' => '', 'usuario' => '', 'password' => '', 'rol' => 'user'
        ];
    }
    require_once __DIR__ . '/../views/admin_crear_usuario.php';
} elseif ($accion === 'editar') {
    $usuarioEditar = $userModel->obtenerPorId($idUsuario);
    if (!$usuarioEditar) {
        header('Location: index.php?seccion=usuarios-administracion');
        exit;
    }
    require_once __DIR__ . '/../views/admin_editar_usuario.php';
} else {
    # Vista principal: Listado
    $usuariosSistema = $userModel->obtenerTodosLosUsuarios();
    require_once __DIR__ . '/../views/admin.php';
}
?>