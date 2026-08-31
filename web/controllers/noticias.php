<?php
# CONTROLADOR DE NOTICIAS
# GESTIONA LA LÓGICA PARA MOSTRAR EL LISTADO O EL DETALLE DE UNA NOTICIA

require_once __DIR__ . '/../models/NoticiasModel.php';

$modeloNoticia = new NoticiaModel();

# Comprobamos si se ha solicitado una noticia en concreto mediante un ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idNoticia = intval($_GET['id']);
    $noticia = $modeloNoticia->obtenerPorId($idNoticia);

    if (!$noticia) {
        // Si la noticia no existe, redirigimos al listado general
        header('Location: index.php?seccion=noticias');
        exit;
    }

    // Cargamos la vista de detalle individual
    require_once __DIR__ . '/../views/noticia_detalle.php';
} else {
    // Si no hay ID, obtenemos todas para el listado general y el Hero
    $noticias = $modeloNoticia->obtenerTodas();
    require_once __DIR__ . '/../views/noticias_list.php';
}
?>