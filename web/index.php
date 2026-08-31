<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
# PUNTO DE ENTRADA DE LA APLICACIÓN (FRONT CONTROLLER)
$seccion = $_GET['seccion'] ?? 'home';

match ($seccion) {
    'noticias'               => require __DIR__ . '/controllers/noticias.php',
    'ver_noticia'            => require __DIR__ . '/controllers/noticias.php',
    'registro'               => require __DIR__ . '/controllers/registro.php',
    'login'                  => require __DIR__ . '/controllers/login.php',
    'logout'                 => require __DIR__ . '/controllers/logout.php',
    'perfil'                 => require __DIR__ . '/controllers/perfil.php',
    'citaciones'             => require __DIR__ . '/controllers/citaciones.php',
    // Secciones de administración
    'usuarios-administracion'  => require __DIR__ . '/controllers/admin.php', 
    'citas-administracion'     => require __DIR__ . '/controllers/citas_admin.php',
    'noticias-administracion'  => require __DIR__ . '/controllers/noticias_admin.php',
    
    default                  => require __DIR__ . '/views/home.php',
};