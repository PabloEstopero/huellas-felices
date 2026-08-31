<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Seguridad: Solo administradores
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] !== 'admin') {
    header('Location: index.php?seccion=home');
    exit;
}

require_once __DIR__ . '/../models/NoticiasModel.php';
$modeloNoticia = new NoticiaModel();

$error = '';
$exito = '';
$noticiaAEditar = null;

# 1. GESTIÓN DE ACCIONES POST (Crear o Editar Noticia)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';
    $titulo = trim($_POST['titulo'] ?? '');
    $texto = trim($_POST['texto'] ?? '');
    $imagen = trim($_POST['imagen'] ?? '');
    $idUser = $_SESSION['user_id']; // El administrador actual es el autor

    if (empty($titulo) || empty($texto) || empty($imagen)) {
        $error = 'Todos los campos de la noticia son obligatorios.';
    } else {
        if ($accion === 'crear') {
            try {
                if ($modeloNoticia->crear($titulo, $texto, $imagen, $idUser)) {
                    header('Location: index.php?seccion=noticias-administracion&exito=creada');
                    exit;
                } else {
                    $error = 'Error al crear la noticia.';
                }
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $error = 'Ya existe una noticia con ese título. Por favor, elige un título diferente.';
                } else {
                    $error = 'Ocurrió un error en la base de datos: ' . $e->getMessage();
                }
            }
        } elseif ($accion === 'editar') {
            $idNoticia = intval($_POST['idNoticia'] ?? 0);
            try {
                if ($modeloNoticia->actualizar($idNoticia, $titulo, $texto, $imagen)) {
                    header('Location: index.php?seccion=noticias-administracion&exito=modificada');
                    exit;
                } else {
                    $error = 'Error al modificar la noticia.';
                }
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $error = 'Ya existe otra noticia con ese título. Por favor, elige uno diferente.';
                } else {
                    $error = 'Ocurrió un error en la base de datos: ' . $e->getMessage();
                }
            }
        }
    }
}

# 2. GESTIÓN DE ACCIONES GET (Borrar o Preparar Edición)
if (isset($_GET['accion'])) {
    $accionGet = $_GET['accion'];
    $idNoticia = intval($_GET['id'] ?? 0);

    if ($accionGet === 'borrar') {
        if ($modeloNoticia->borrar($idNoticia)) {
            header('Location: index.php?seccion=noticias-administracion&exito=borrada');
            exit;
        } else {
            $error = 'No se pudo eliminar la noticia.';
        }
    } elseif ($accionGet === 'preparar_editar') {
        $noticiaAEditar = $modeloNoticia->obtenerPorId($idNoticia);
        if (!$noticiaAEditar) {
            $error = 'La noticia seleccionada no existe.';
        }
    }
}

# Capturar mensajes de éxito por URL
if (isset($_GET['exito'])) {
    if ($_GET['exito'] === 'creada') $exito = 'Noticia creada correctamente.';
    if ($_GET['exito'] === 'modificada') $exito = 'Noticia modificada correctamente.';
    if ($_GET['exito'] === 'borrada') $exito = 'Noticia eliminada correctamente.';
}

# Obtener todas las noticias para listarlas en la administración
$noticias = $modeloNoticia->obtenerTodas();

# Cargar la vista de administración de noticias
require_once __DIR__ . '/../views/noticias_administracion.php';
?>