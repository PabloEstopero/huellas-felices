<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Seguridad: Solo administradores
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php?seccion=home');
    exit;
}

require_once __DIR__ . '/../models/CitaModel.php';
require_once __DIR__ . '/../models/UserModel.php';

$citaModel = new CitaModel();
$userModel = new UserModel();

$error = '';
$exito = '';
$citaAEditar = null;

# 1. Obtener la lista de usuarios para que el admin pueda seleccionarlos
$usuariosSistema = $userModel->obtenerTodosLosUsuarios();

# 2. Determinar qué usuario está seleccionado actualmente (por GET o POST)
$idUserSeleccionado = intval($_GET['idUser'] ?? ($_POST['idUser'] ?? 0));

# 3. GESTIÓN DE ACCIONES POST (Crear o Editar Cita)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $idUserSeleccionado = intval($_POST['idUser'] ?? 0);
    $fechaCita = $_POST['fecha_cita'] ?? '';
    $motivoCita = trim($_POST['motivo_cita'] ?? '');

    if ($idUserSeleccionado === 0) {
        $error = 'Debes seleccionar un usuario válido.';
    } elseif (empty($fechaCita) || empty($motivoCita)) {
        $error = 'Todos los campos de la cita son obligatorios.';
    } elseif ($fechaCita < date('Y-m-d')) {
        $error = 'No puedes programar una cita para una fecha anterior a hoy.';
    } else {
        if ($accion === 'crear') {
            if ($citaModel->crearCitaAdmin($idUserSeleccionado, $fechaCita, $motivoCita)) {
                header('Location: index.php?seccion=citas-administracion&idUser=' . $idUserSeleccionado . '&exito=creada');
                exit;
            } else {
                $error = 'Error al crear la cita.';
            }
        } elseif ($accion === 'editar') {
            $idCita = intval($_POST['idCita'] ?? 0);
            if ($citaModel->actualizarCitaAdmin($idCita, $fechaCita, $motivoCita)) {
                header('Location: index.php?seccion=citas-administracion&idUser=' . $idUserSeleccionado . '&exito=modificada');
                exit;
            } else {
                $error = 'No se pudo modificar la cita (verifica que la fecha no sea pasada).';
            }
        }
    }
}

# 4. GESTIÓN DE ACCIONES GET (Borrar o Preparar Edición)
if (isset($_GET['accion'])) {
    $accionGet = $_GET['accion'];
    $idCita = intval($_GET['id'] ?? 0);

    if ($accionGet === 'preparar_editar') {
        $citaAEditar = $citaModel->obtenerCitaPorId($idCita);
        if (!$citaAEditar) {
            $error = 'La cita seleccionada no existe.';
        } else {
            // Asegurarnos de que el usuario seleccionado coincida con el de la cita cargada
            $idUserSeleccionado = (int)$citaAEditar['idUser'];
        }
    } elseif ($accionGet === 'borrar') {
        // Obtener el idUser de la cita antes de borrarla para no perder el filtro en la redirección
        $infoCita = $citaModel->obtenerCitaPorId($idCita);
        $idUserDestino = $infoCita ? $infoCita['idUser'] : $idUserSeleccionado;

        if ($citaModel->borrarCitaAdmin($idCita)) {
            header('Location: index.php?seccion=citas-administracion&idUser=' . $idUserDestino . '&exito=borrada');
            exit;
        } else {
            $error = 'No se pudo eliminar la cita.';
        }
    }
}

# Capturar mensajes de éxito por URL
if (isset($_GET['exito'])) {
    if ($_GET['exito'] === 'creada') $exito = 'Cita creada correctamente para el usuario.';
    if ($_GET['exito'] === 'modificada') $exito = 'Cita modificada correctamente.';
    if ($_GET['exito'] === 'borrada') $exito = 'Cita eliminada correctamente.';
}

# Obtener las citas del usuario seleccionado (si hay uno elegido)
$citasUsuario = [];
if ($idUserSeleccionado > 0) {
    $citasUsuario = $citaModel->obtenerCitasPorUsuario($idUserSeleccionado);
}

# Cargar la vista de administración de citas
require_once __DIR__ . '/../views/citas_administracion.php';
?>