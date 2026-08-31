<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Comprobamos que el usuario haya iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?seccion=login');
    exit;
}

require_once __DIR__ . '/../models/CitaModel.php';
$citaModel = new CitaModel();
$idUser = $_SESSION['user_id'];

$error = '';
$exito = '';
$citaAEditar = null;

# GESTIÓN DE ACCIONES (CREAR, EDITAR) POR POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'crear') {
        $fechaCita = $_POST['fecha_cita'] ?? '';
        $motivoCita = trim($_POST['motivo_cita'] ?? '');

        if (empty($fechaCita) || empty($motivoCita)) {
            $error = 'Todos los campos de la cita son obligatorios.';
        } elseif ($fechaCita < date('Y-m-d')) {
            $error = 'No puedes solicitar una cita para una fecha anterior a hoy.';
        } else {
            if ($citaModel->crearCita($idUser, $fechaCita, $motivoCita)) {
                # REDIRECCIÓN PRG: Evita que al recargar (F5) se duplique la cita
                header('Location: index.php?seccion=citaciones&exito=creada');
                exit;
            } else {
                $error = 'Error al solicitar la cita.';
            }
        }
    } elseif ($accion === 'editar') {
        $idCita = intval($_POST['idCita'] ?? 0);
        $fechaCita = $_POST['fecha_cita'] ?? '';
        $motivoCita = trim($_POST['motivo_cita'] ?? '');

        if (empty($fechaCita) || empty($motivoCita)) {
            $error = 'Todos los campos son obligatorios para modificar la cita.';
        } elseif ($fechaCita < date('Y-m-d')) {
            $error = 'No puedes mover una cita a una fecha pasada.';
        } else {
            if ($citaModel->actualizarCita($idCita, $idUser, $fechaCita, $motivoCita)) {
                # REDIRECCIÓN PRG: Evita duplicados al recargar
                header('Location: index.php?seccion=citaciones&exito=modificada');
                exit;
            } else {
                $error = 'No se pudo modificar la cita.';
            }
        }
    }
}

# GESTIÓN DE ACCIONES POR GET (Borrar o preparar edición)
if (isset($_GET['accion'])) {
    $idCita = intval($_GET['id'] ?? 0);

    if ($_GET['accion'] === 'borrar') {
        if ($citaModel->borrarCita($idCita, $idUser)) {
            # REDIRECCIÓN PRG tras borrar
            header('Location: index.php?seccion=citaciones&exito=borrada');
            exit;
        } else {
            $error = 'No se puede borrar una cita pasada o que no te pertenece.';
        }
    } elseif ($_GET['accion'] === 'preparar_editar') {
        $citaAEditar = $citaModel->obtenerCitaPorId($idCita);
        if (!$citaAEditar || $citaAEditar['fecha_cita'] < date('Y-m-d')) {
            $error = 'No se puede editar una cita ya pasada.';
            $citaAEditar = null;
        }
    }
}

# Capturamos los mensajes de éxito enviados por la URL tras la redirección
if (isset($_GET['exito'])) {
    if ($_GET['exito'] === 'creada') $exito = 'Cita solicitada correctamente.';
    if ($_GET['exito'] === 'modificada') $exito = 'Cita modificada correctamente.';
    if ($_GET['exito'] === 'borrada') $exito = 'Cita borrada correctamente.';
}

# Obtenemos la lista actualizada de citas del usuario
$citasUsuario = $citaModel->obtenerCitasPorUsuario($idUser);

# Cargamos la vista de citaciones
require_once __DIR__ . '/../views/citaciones.php';
?>